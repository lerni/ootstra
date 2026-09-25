<?php

namespace App\Tasks;

use App\Models\Slide;
use App\Elements\ElementHero;
use App\Utility\ImageUrlResolver;
use SilverStripe\CMS\Model\SiteTree;
use Kraftausdruck\Tasks\McpBuildTask;
use SilverStripe\Versioned\Versioned;
use Kraftausdruck\Utility\AssetImporter;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Reusable create/update of Slide records (title, text, text alignment, image) from a JSON
 * array, attached to an ElementHero block on a chosen page. Images are fetched from a URL
 * via AssetImporter and only imported once per Slide — an existing SlideImage is never
 * replaced. Never creates/edits a Link — attach those manually in the CMS.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-hero --url-segment=home --data=@/path/to/slides.json
 */
class ManageHeroTask extends McpBuildTask
{
    protected static string $commandName = 'manage-hero';

    protected string $title = 'Manage Hero';

    protected static string $description = 'Creates/updates Slide records (title, text, text_alignment, show_title, title_level, image) from a JSON array and attaches them to an ElementHero block on the given page.';

    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, sprintf(
                'JSON array of slides: [{"id","title","text","text_alignment","show_title","title_level","image","sort"}, ...]. "id" (optional) is an existing Slide ID to update; otherwise a Slide already attached to the target ElementHero is matched by "title", or a new one is created. "text_alignment" must be one of (%s); "title_level" must be one of (%s). "image" is a URL, only fetched if the Slide has no SlideImage yet — an existing image is never replaced. Any key omitted entirely is left untouched on update. Prefix with @ to read from a file.',
                implode(', ', self::getAllowedTextAlignments()),
                implode(', ', self::getAllowedTitleLevels()),
            )),
            new InputOption('url-segment', null, InputOption::VALUE_REQUIRED, 'URLSegment of the page to attach the block to', 'home'),
            new InputOption('element-id', null, InputOption::VALUE_REQUIRED, 'Existing ElementHero ID to add to (optional — otherwise reuses/creates the ElementHero on the page)'),
            new InputOption('publish', null, InputOption::VALUE_NONE, 'Publish the ElementHero block'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Preview without writing to the database'),
        ]);
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        // sake defaults to the Live stage, which dual-writes every change straight to Live — force
        // Draft so this behaves like a normal CMS edit, only reaching Live via --publish.
        Versioned::set_stage(Versioned::DRAFT);

        $rawData = (string) $input->getOption('data');
        if (str_starts_with($rawData, '@')) {
            $rawData = (string) file_get_contents(substr($rawData, 1));
        }

        $slides = json_decode($rawData, true);
        if (!is_array($slides) || !$slides) {
            $output->writeln('<error>--data must be a non-empty JSON array of slide objects.</error>');

            return Command::FAILURE;
        }

        $urlSegment = (string) ($input->getOption('url-segment') ?: 'home');
        $page = SiteTree::get()->filter('URLSegment', $urlSegment)->first();

        if (!$page || !$page->hasMethod('ElementalArea') || !$page->ElementalArea()->exists()) {
            $output->writeln(sprintf('<error>Page "%s" or its ElementalArea not found.</error>', $urlSegment));

            return Command::FAILURE;
        }

        $elementId = (int) $input->getOption('element-id');
        $dryRun = (bool) $input->getOption('dry-run');

        if ($elementId) {
            $element = ElementHero::get()->byID($elementId);

            if (!$element) {
                $output->writeln(sprintf('<error>ElementHero #%d not found.</error>', $elementId));

                return Command::FAILURE;
            }
        } else {
            $element = ElementHero::get()->filter('ParentID', $page->ElementalArea()->ID)->first();

            if (!$element) {
                $allowedElements = $page->config()->get('allowed_elements');
                if (is_array($allowedElements) && !in_array(ElementHero::class, $allowedElements, true)) {
                    $output->writeln(sprintf('<error>%s does not allow ElementHero blocks (see its "allowed_elements" config).</error>', $page->ClassName));

                    return Command::FAILURE;
                }

                $element = ElementHero::create();
                $element->ParentID = $page->ElementalArea()->ID;
            }
        }

        if ($dryRun) {
            $wouldImport = 0;
            foreach ($slides as $data) {
                if (!is_array($data)) {
                    continue;
                }

                $title = trim((string) ($data['title'] ?? ''));
                $output->writeln(sprintf('Would import slide: %s%s', $title ?: '(untitled)', !empty($data['image']) ? ' [image]' : ''));
                ++$wouldImport;
            }
            $output->writeln(sprintf('[dry-run] %d slide(s) would be added to ElementHero #%s.', $wouldImport, $element->ID ?: 'new'));

            return Command::SUCCESS;
        }

        $element->write();

        $existingSlides = $element->Slides();
        $sort = (int) $existingSlides->count();
        $imported = 0;

        foreach ($slides as $data) {
            if (!is_array($data)) {
                continue;
            }

            $id = (int) ($data['id'] ?? 0);
            $title = trim((string) ($data['title'] ?? ''));

            $slide = null;
            if ($id) {
                $slide = Slide::get()->byID($id);

                if (!$slide) {
                    $output->writeln(sprintf('<error>Slide #%d not found.</error>', $id));

                    continue;
                }
            } elseif ($title !== '') {
                $slide = $existingSlides->filter('Title', $title)->first();
            }

            if (!$slide) {
                $slide = Slide::create();
            }

            try {
                self::applyFields($slide, $data, $output);
                $slide->write();

                $imgUrl = (string) ($data['image'] ?? '');
                if (!$slide->SlideImage()->exists() && $imgUrl) {
                    $this->attachSlideImage($slide, $imgUrl, $output);
                }

                if (!$existingSlides->filter('ID', $slide->ID)->exists()) {
                    $element->Slides()->add($slide, ['SortOrder' => ++$sort]);
                } elseif (array_key_exists('sort', $data)) {
                    $element->Slides()->add($slide, ['SortOrder' => (int) $data['sort']]);
                }
            } catch (\Throwable $e) {
                $output->writeln(sprintf('<error>Failed to save slide "%s": %s</error>', $title ?: $slide->ID, $e->getMessage()));

                continue;
            }

            $output->writeln(sprintf('  %s (Slide #%d)', $slide->Title ?: '(untitled)', $slide->ID));
            ++$imported;
        }

        if ((bool) $input->getOption('publish')) {
            $element->publishRecursive();
        }

        $output->writeln(sprintf('Imported %d slide(s) into ElementHero #%d.', $imported, $element->ID));

        return Command::SUCCESS;
    }

    /** Sets Slide fields present in $data (array_key_exists), leaving anything omitted untouched; invalid enum values are warned about and skipped. */
    private static function applyFields(Slide $slide, array $data, PolyOutput $output): void
    {
        if (array_key_exists('title', $data)) {
            $slide->Title = (string) $data['title'];
        }

        if (array_key_exists('text', $data)) {
            $slide->Text = (string) $data['text'];
        }

        if (array_key_exists('show_title', $data)) {
            $slide->ShowTitle = (int) (bool) $data['show_title'];
        }

        if (array_key_exists('text_alignment', $data)) {
            $textAlignment = (string) $data['text_alignment'];
            $allowedTextAlignments = self::getAllowedTextAlignments();

            if (in_array($textAlignment, $allowedTextAlignments, true)) {
                $slide->TextAlignment = $textAlignment;
            } else {
                $output->writeln(sprintf('<comment>  ignoring invalid text_alignment "%s" (must be one of: %s)</comment>', $textAlignment, implode(', ', $allowedTextAlignments)));
            }
        }

        if (array_key_exists('title_level', $data)) {
            $titleLevel = (string) $data['title_level'];
            $allowedTitleLevels = self::getAllowedTitleLevels();

            if (in_array($titleLevel, $allowedTitleLevels, true)) {
                $slide->TitleLevel = $titleLevel;
            } else {
                $output->writeln(sprintf('<comment>  ignoring invalid title_level "%s" (must be one of: %s)</comment>', $titleLevel, implode(', ', $allowedTitleLevels)));
            }
        }
    }

    private function attachSlideImage(Slide $slide, string $url, PolyOutput $output): void
    {
        $image = AssetImporter::createFromUrl(ImageUrlResolver::resolveOriginal($url), 'Slides');

        if ($image) {
            $slide->SlideImageID = $image->ID;
            $slide->write();
        } else {
            $output->writeln(sprintf('<comment>  SlideImage import failed for "%s".</comment>', $url));
        }
    }

    /** @return string[] */
    private static function getAllowedTextAlignments(): array
    {
        return Slide::singleton()->dbObject('TextAlignment')->enumValues();
    }

    /** @return string[] */
    private static function getAllowedTitleLevels(): array
    {
        return Slide::singleton()->dbObject('TitleLevel')->enumValues();
    }
}
