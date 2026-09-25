<?php

namespace App\Tasks;

use App\Util\ImageUrlResolver;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Blog\Model\BlogTag;
use SilverStripe\CMS\Model\SiteTree;
use Kraftausdruck\Tasks\McpBuildTask;
use SilverStripe\Blog\Model\BlogPost;
use SilverStripe\Versioned\Versioned;
use Kraftausdruck\Utility\AssetImporter;
use SilverStripe\Blog\Model\BlogCategory;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Reusable create/update of SilverStripe\Blog\Model\Blog holder pages and their
 * SilverStripe\Blog\Model\BlogPost entries from a single nested JSON array — designed to
 * import a whole blog (holder + posts) in one call, or just add/update posts under an
 * existing holder. Never creates ElementContent blocks — use manage-content for that, and
 * never creates BlogCategory/BlogTag — only attaches existing ones by Title or ID.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-blog --data=@/path/to/blog.json
 */
class ManageBlogTask extends McpBuildTask
{
    protected static string $commandName = 'manage-blog';

    protected string $title = 'Manage Blog';

    protected static string $description = 'Creates/updates Blog holder pages and their BlogPost entries from a nested JSON array. Never creates ElementContent blocks (use manage-content) or BlogCategory/BlogTag (only attaches existing ones by Title/ID).';

    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, 'JSON array of blog holders: [{"id","url_segment","title","parent_url_segment","meta_description","show_in_menus","posts_per_page","posts":[{"id","url_segment","title","publish_date","author_names","summary","featured_image","categories":[...],"tags":[...],"meta_description","show_in_menus","sort"}, ...]}, ...]. "id" (optional) or "url_segment" identifies an existing Blog/BlogPost to update; otherwise a new one is created (Blog requires "title", BlogPost is parented under its holder). "parent_url_segment" (Blog only, omit/empty for site root) re-parents like manage-element-pages. "categories"/"tags" are arrays of existing BlogCategory/BlogTag, each matched by Title or numeric ID — unmatched entries are reported and skipped, never created; replaces the full set. "featured_image" is a URL, only fetched if the post has no FeaturedImage yet. Any key omitted entirely is left untouched on update; "posts" omitted entirely leaves the holder\'s existing posts untouched. Prefix with @ to read from a file.'),
            new InputOption('publish', null, InputOption::VALUE_NONE, 'Publish each created/updated Blog and BlogPost'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Preview without writing to the database'),
        ]);
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        // sake defaults to the Live stage, which dual-writes every change straight to Live and
        // skips ElementalArea auto-creation (DNADesign\Elemental requires Draft for that) — force Draft
        // so writes behave like a normal CMS edit, only reaching Live via the explicit --publish flag.
        Versioned::set_stage(Versioned::DRAFT);

        $rawData = (string) $input->getOption('data');
        if (str_starts_with($rawData, '@')) {
            $rawData = (string) file_get_contents(substr($rawData, 1));
        }

        $blogs = json_decode($rawData, true);
        if (!is_array($blogs) || !$blogs) {
            $output->writeln('<error>--data must be a non-empty JSON array of blog holder objects.</error>');

            return Command::FAILURE;
        }

        $dryRun = (bool) $input->getOption('dry-run');
        $publish = (bool) $input->getOption('publish');
        $importedBlogs = 0;
        $importedPosts = 0;

        foreach ($blogs as $blogData) {
            if (!is_array($blogData)) {
                continue;
            }

            $blog = $this->findOrCreateBlog($blogData, $output);

            if (!$blog) {
                continue;
            }

            $this->applyBlogFields($blog, $blogData, $output);

            if ($dryRun) {
                $output->writeln(sprintf(
                    'Would %s Blog "%s"',
                    $blog->isInDB() ? 'update' : 'create',
                    $blog->Title ?: $blog->URLSegment,
                ));
            } else {
                $blog->write();

                if ($publish) {
                    $blog->publishRecursive();
                }

                $output->writeln(sprintf('  %s (Blog #%d)', $blog->Title, $blog->ID));
            }

            ++$importedBlogs;

            $posts = $blogData['posts'] ?? null;
            if (!is_array($posts)) {
                continue;
            }

            foreach ($posts as $postData) {
                if (!is_array($postData)) {
                    continue;
                }

                if ($this->importPost($blog, $postData, $dryRun, $publish, $output)) {
                    ++$importedPosts;
                }
            }
        }

        $output->writeln(sprintf(
            '%s %d blog(s) and %d post(s).',
            $dryRun ? '[dry-run] Would import' : 'Imported',
            $importedBlogs,
            $importedPosts,
        ));

        return Command::SUCCESS;
    }

    private function findOrCreateBlog(array $data, PolyOutput $output): ?Blog
    {
        $id = (int) ($data['id'] ?? 0);
        $urlSegment = trim((string) ($data['url_segment'] ?? ''));

        if ($id) {
            $blog = Blog::get()->byID($id);

            if (!$blog) {
                $output->writeln(sprintf('<error>Blog #%d not found.</error>', $id));

                return null;
            }

            return $blog;
        }

        if ($urlSegment !== '') {
            $blog = Blog::get()->filter('URLSegment', $urlSegment)->first();
            if ($blog) {
                return $blog;
            }
        }

        if (trim((string) ($data['title'] ?? '')) === '') {
            $output->writeln('<error>Skipping blog entry without "title" (required to create a new Blog).</error>');

            return null;
        }

        return Blog::create();
    }

    private function applyBlogFields(Blog $blog, array $data, PolyOutput $output): void
    {
        // "parent_url_segment" omitted entirely leaves ParentID untouched; present but empty
        // explicitly re-parents to the site root.
        if (array_key_exists('parent_url_segment', $data)) {
            $parentSegment = trim((string) $data['parent_url_segment']);
            $parent = $parentSegment !== '' ? SiteTree::get()->filter('URLSegment', $parentSegment)->first() : null;

            if ($parentSegment !== '' && !$parent) {
                $output->writeln(sprintf('<comment>Parent page "%s" not found — leaving ParentID unset.</comment>', $parentSegment));
            } else {
                $blog->ParentID = $parent ? $parent->ID : 0;
            }
        }

        if (array_key_exists('title', $data)) {
            $blog->Title = (string) $data['title'];
        }
        if (array_key_exists('url_segment', $data)) {
            $blog->URLSegment = (string) $data['url_segment'];
        }
        if (array_key_exists('meta_description', $data)) {
            $blog->MetaDescription = (string) $data['meta_description'];
        }
        if (array_key_exists('show_in_menus', $data)) {
            $blog->ShowInMenus = (int) (bool) $data['show_in_menus'];
        }
        if (array_key_exists('posts_per_page', $data)) {
            $blog->PostsPerPage = (int) $data['posts_per_page'];
        }
    }

    private function importPost(Blog $blog, array $data, bool $dryRun, bool $publish, PolyOutput $output): bool
    {
        $id = (int) ($data['id'] ?? 0);
        $urlSegment = trim((string) ($data['url_segment'] ?? ''));
        $title = trim((string) ($data['title'] ?? ''));

        $post = null;
        if ($id) {
            $post = BlogPost::get()->byID($id);

            if (!$post) {
                $output->writeln(sprintf('<error>BlogPost #%d not found.</error>', $id));

                return false;
            }
        } elseif ($urlSegment !== '') {
            $post = BlogPost::get()->filter(['URLSegment' => $urlSegment, 'ParentID' => $blog->ID])->first();
        }

        if (!$post) {
            if ($title === '') {
                $output->writeln('<error>Skipping post entry without "title".</error>');

                return false;
            }
            $post = BlogPost::create();
            $post->ParentID = $blog->ID;
        }

        if ($title !== '') {
            $post->Title = $title;
        }
        if ($urlSegment !== '') {
            $post->URLSegment = $urlSegment;
        }
        if (array_key_exists('publish_date', $data)) {
            $post->PublishDate = (string) $data['publish_date'];
        }
        if (array_key_exists('author_names', $data)) {
            $post->AuthorNames = (string) $data['author_names'];
        }
        if (array_key_exists('summary', $data)) {
            $post->Summary = (string) $data['summary'];
        }
        if (array_key_exists('meta_description', $data)) {
            $post->MetaDescription = (string) $data['meta_description'];
        }
        if (array_key_exists('show_in_menus', $data)) {
            $post->ShowInMenus = (int) (bool) $data['show_in_menus'];
        }
        if (array_key_exists('sort', $data)) {
            $post->Sort = (int) $data['sort'];
        }

        $hasCategories = array_key_exists('categories', $data);
        [$categories, $missingCategories] = $hasCategories && is_array($data['categories'])
            ? $this->resolveByIdentifiers(BlogCategory::class, $data['categories'])
            : [[], []];

        $hasTags = array_key_exists('tags', $data);
        [$tags, $missingTags] = $hasTags && is_array($data['tags'])
            ? $this->resolveByIdentifiers(BlogTag::class, $data['tags'])
            : [[], []];

        if ($dryRun) {
            $output->writeln(sprintf(
                'Would %s BlogPost "%s"%s%s',
                $post->isInDB() ? 'update' : 'create',
                $title ?: $post->Title,
                $categories ? sprintf(' [Categories: %s]', implode(', ', array_map(fn ($c) => $c->Title, $categories))) : '',
                $tags ? sprintf(' [Tags: %s]', implode(', ', array_map(fn ($t) => $t->Title, $tags))) : '',
            ));
            foreach (array_merge($missingCategories, $missingTags) as $missing) {
                $output->writeln(sprintf('<comment>  not found, would be skipped: %s</comment>', $missing));
            }

            return true;
        }

        try {
            $post->write();

            if ($hasCategories) {
                $post->Categories()->setByIDList(array_map(fn ($c) => $c->ID, $categories));
            }
            if ($hasTags) {
                $post->Tags()->setByIDList(array_map(fn ($t) => $t->ID, $tags));
            }

            $imgUrl = (string) ($data['featured_image'] ?? '');
            if (!$post->FeaturedImage()->exists() && $imgUrl !== '') {
                $this->attachFeaturedImage($post, $imgUrl, $output);
            }

            if ($publish) {
                $post->publishRecursive();
            }
        } catch (\Throwable $e) {
            $output->writeln(sprintf('<error>Failed to save BlogPost "%s": %s</error>', $title ?: $post->Title, $e->getMessage()));

            return false;
        }

        foreach (array_merge($missingCategories, $missingTags) as $missing) {
            $output->writeln(sprintf('<comment>  not found, skipped: %s</comment>', $missing));
        }

        $output->writeln(sprintf('  %s (BlogPost #%d)', $post->Title, $post->ID));

        return true;
    }

    private function attachFeaturedImage(BlogPost $post, string $url, PolyOutput $output): void
    {
        $folder = (string) BlogPost::config()->get('featured_images_directory') ?: 'BlogPostImages';
        $image = AssetImporter::createFromUrl(ImageUrlResolver::resolveOriginal($url), $folder);

        if ($image) {
            $post->FeaturedImageID = $image->ID;
            $post->write();
        } else {
            $output->writeln(sprintf('<comment>  FeaturedImage import failed for "%s".</comment>', $url));
        }
    }

    /**
     * Matches existing DataObjects of $class by numeric ID or Title — never creates one.
     *
     * @return array{0: object[], 1: mixed[]} [matched objects, unmatched identifiers]
     */
    private function resolveByIdentifiers(string $class, array $identifiers): array
    {
        $matched = [];
        $missing = [];

        foreach ($identifiers as $identifier) {
            $object = is_numeric($identifier)
                ? $class::get()->byID((int) $identifier)
                : $class::get()->filter('Title', (string) $identifier)->first();

            if ($object) {
                $matched[] = $object;
            } else {
                $missing[] = $identifier;
            }
        }

        return [$matched, $missing];
    }
}
