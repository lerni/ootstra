<?php

namespace App\Tasks;

use App\Models\ElementPage;
use SilverStripe\CMS\Model\SiteTree;
use Kraftausdruck\Tasks\McpBuildTask;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Blog\Model\BlogCategory;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Reusable create/update of ElementPage records (modular pages built from Elemental blocks —
 * use ManageContentTask to manage their ElementContent blocks) from a JSON array. Pages are
 * matched by "id" or "url_segment" and parented by an existing page's URLSegment.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-element-pages --data=@/path/to/pages.json
 */
class ManageElementPageTask extends McpBuildTask
{
    protected static string $commandName = 'manage-element-pages';

    protected string $title = 'Manage Element Pages';

    protected static string $description = 'Creates/updates ElementPage records (Title, URLSegment, ParentID, MetaDescription, ShowInMenus, Sort, PageCategories) from a JSON array. Never creates ElementContent blocks — use manage-content for that.';

    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, 'JSON array of pages: [{"id","title","url_segment","parent_url_segment","meta_description","show_in_menus","sort","page_categories"}, ...]. "id" (optional) or "url_segment" identifies an existing ElementPage to update; otherwise a new one is created, parented under "parent_url_segment" (omit/empty for site root). "page_categories" is an array of existing BlogCategory, each matched by Title or numeric ID — unmatched entries are reported and skipped, never created; replaces the full set. Any key omitted entirely is left untouched on update. Prefix with @ to read from a file.'),
            new InputOption('publish', null, InputOption::VALUE_NONE, 'Publish each created/updated page'),
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

        $pages = json_decode($rawData, true);
        if (!is_array($pages) || !$pages) {
            $output->writeln('<error>--data must be a non-empty JSON array of page objects.</error>');

            return Command::FAILURE;
        }

        $dryRun = (bool) $input->getOption('dry-run');
        $publish = (bool) $input->getOption('publish');
        $imported = 0;

        foreach ($pages as $data) {
            if (!is_array($data)) {
                continue;
            }

            $id = (int) ($data['id'] ?? 0);
            $urlSegment = trim((string) ($data['url_segment'] ?? ''));
            $title = trim((string) ($data['title'] ?? ''));

            $page = null;
            if ($id) {
                $page = ElementPage::get()->byID($id);

                if (!$page) {
                    $output->writeln(sprintf('<error>ElementPage #%d not found.</error>', $id));

                    continue;
                }
            } elseif ($urlSegment !== '') {
                $page = ElementPage::get()->filter('URLSegment', $urlSegment)->first();
            }

            if (!$page) {
                if ($title === '') {
                    $output->writeln('<error>Skipping entry without "title".</error>');

                    continue;
                }
                $page = ElementPage::create();
            }

            // "parent_url_segment" omitted entirely leaves ParentID untouched; present but empty
            // explicitly re-parents to the site root — always reported below since it's easy to
            // trigger by accident and silently moving an existing page is disruptive.
            $parentLabel = null;
            if (array_key_exists('parent_url_segment', $data)) {
                $parentSegment = trim((string) $data['parent_url_segment']);
                $parent = $parentSegment !== '' ? SiteTree::get()->filter('URLSegment', $parentSegment)->first() : null;

                if ($parentSegment !== '' && !$parent) {
                    $output->writeln(sprintf('<comment>Parent page "%s" not found — leaving ParentID unset.</comment>', $parentSegment));
                } else {
                    $page->ParentID = $parent ? $parent->ID : 0;
                    $parentLabel = $parent ? $parentSegment : 'site root';
                }
            }

            if ($title !== '') {
                $page->Title = $title;
            }
            if ($urlSegment !== '') {
                $page->URLSegment = $urlSegment;
            }
            if (array_key_exists('meta_description', $data)) {
                $page->MetaDescription = (string) $data['meta_description'];
            }
            if (array_key_exists('show_in_menus', $data)) {
                $page->ShowInMenus = (int) (bool) $data['show_in_menus'];
            }
            if (array_key_exists('sort', $data)) {
                $page->Sort = (int) $data['sort'];
            }

            // Omitting this key entirely leaves existing PageCategories untouched
            $hasPageCategories = array_key_exists('page_categories', $data);
            $categories = [];
            $missingCategories = [];
            if ($hasPageCategories && is_array($data['page_categories'])) {
                foreach ($data['page_categories'] as $identifier) {
                    $category = $this->findCategory($identifier);
                    if ($category) {
                        $categories[] = $category;
                    } else {
                        $missingCategories[] = $identifier;
                    }
                }
            }

            if ($dryRun) {
                $output->writeln(sprintf(
                    'Would %s ElementPage "%s"%s%s',
                    $page->isInDB() ? 'update' : 'create',
                    $page->Title ?: $urlSegment,
                    $parentLabel !== null ? sprintf(' [Parent: %s]', $parentLabel) : '',
                    $categories ? sprintf(' [PageCategories: %s]', implode(', ', array_map(fn ($c) => $c->Title, $categories))) : '',
                ));
                foreach ($missingCategories as $missing) {
                    $output->writeln(sprintf('<comment>  not found, would be skipped: %s</comment>', $missing));
                }

                ++$imported;

                continue;
            }

            $page->write();

            if ($hasPageCategories) {
                $page->PageCategories()->setByIDList(array_map(fn ($c) => $c->ID, $categories));
            }

            foreach ($missingCategories as $missing) {
                $output->writeln(sprintf('<comment>  not found, skipped: %s</comment>', $missing));
            }

            if ($publish) {
                $page->publishRecursive();
            }

            $output->writeln(sprintf(
                '  %s (ElementPage #%d)%s',
                $page->Title,
                $page->ID,
                $parentLabel !== null ? sprintf(' [Parent: %s]', $parentLabel) : '',
            ));
            ++$imported;
        }

        $output->writeln(sprintf('%s %d page(s).', $dryRun ? '[dry-run] Would import' : 'Imported', $imported));

        return Command::SUCCESS;
    }

    /** Matches an existing BlogCategory by numeric ID or Title — never creates one. */
    private function findCategory(mixed $identifier): ?BlogCategory
    {
        if (is_numeric($identifier)) {
            return BlogCategory::get()->byID((int) $identifier);
        }

        return BlogCategory::get()->filter('Title', (string) $identifier)->first();
    }
}
