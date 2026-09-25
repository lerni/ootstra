<?php

namespace App\Tasks;

use App\Extensions\ElementExtension;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Config\Config;
use Kraftausdruck\Tasks\McpBuildTask;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\FieldType\DBEnum;
use SilverStripe\TinyMCE\TinyMCEConfig;
use SilverStripe\View\Parsers\HTMLValue;
use SilverStripe\PolyExecution\PolyOutput;
use DNADesign\Elemental\Models\ElementContent;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use SilverStripe\Forms\HTMLEditor\HTMLEditorConfig;
use Symfony\Component\Console\Input\InputInterface;
use SilverStripe\Forms\HTMLEditor\HTMLEditorSanitiser;
use SilverStripe\Forms\HTMLEditor\HTMLEditorElementRule;

/**
 * Reusable create/update of ElementContent (HTML content) blocks from a JSON array, attached
 * to a page's ElementalArea. HTML is sanitised through the "cms" HTMLEditorConfig — the same
 * tag/attribute allow-list TinyMCE enforces client-side (see
 * https://docs.silverstripe.org/en/6/optional_features/htmleditor-tinymce/configuration/ and
 * https://docs.silverstripe.org/en/6/developer_guides/forms/field_types/htmleditorfield/) — and
 * any "class" attribute is restricted to the style_formats classes defined via $styles in
 * app/_config.php. Never creates ElementContent on a page type that disallows it.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-content --url-segment=home --data=@/path/to/content.json
 */
class ManageContentTask extends McpBuildTask
{
    protected static string $commandName = 'manage-content';

    protected string $title = 'Manage Content';

    protected static string $description = 'Creates/updates ElementContent blocks from a JSON array of {id, html} objects, sanitising HTML against the "cms" HTMLEditorConfig allow-list and restricting class attributes to the configured style_formats.';

    /** The full allow-list already lives in the "data" option's description — don't repeat it here, just point to it. */
    public static function getDescription(): string
    {
        return parent::getDescription() . ' See the "data" option description for the current list of allowed elements/classes.';
    }

    public function getOptions(): array
    {
        $config = HTMLEditorConfig::get('cms');

        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, sprintf(
                'JSON array of content blocks: [{"id","html","title","show_title","is_full_width","title_level","background_color"}, ...]. "id" (optional) is an existing ElementContent ID to update; omit it to append a new block to --url-segment\'s page. "title"/"show_title"/"is_full_width" (bool) map to BaseElement/ElementExtension fields; "title_level" must be one of (%s); "background_color" must be one of (%s). Any key omitted entirely is left untouched on update. HTML is sanitised: only these elements are kept (%s); any "class" attribute is restricted to (%s) — anything else is silently stripped, so only use these. Prefix with @ to read from a file.',
                implode(', ', self::getAllowedTitleLevels()),
                implode(', ', self::getAllowedBackgroundColors()),
                implode(', ', self::getAllowedElementNames($config)),
                implode(', ', self::getAllowedStyleClasses($config)),
            )),
            new InputOption('url-segment', null, InputOption::VALUE_REQUIRED, 'URLSegment of the page new blocks are appended to (required unless "id" is given for every block)'),
            new InputOption('publish', null, InputOption::VALUE_NONE, 'Publish each created/updated content block'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Preview without writing to the database'),
        ]);
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        // sake defaults to the Live stage, which dual-writes every change straight to Live (and can
        // clobber unpublished draft edits on existing blocks) — force Draft so this behaves like a
        // normal CMS edit.
        Versioned::set_stage(Versioned::DRAFT);

        $rawData = (string) $input->getOption('data');
        if (str_starts_with($rawData, '@')) {
            $rawData = (string) file_get_contents(substr($rawData, 1));
        }

        $blocks = json_decode($rawData, true);
        if (!is_array($blocks) || !$blocks) {
            $output->writeln('<error>--data must be a non-empty JSON array of {id, html} objects.</error>');

            return Command::FAILURE;
        }

        // --url-segment (and the page/ElementalArea/allowed_elements checks that go with it) is only
        // needed to know where to append brand new blocks — a batch that exclusively updates existing
        // blocks by "id" doesn't touch any page and shouldn't be blocked by it.
        $needsPage = false;
        foreach ($blocks as $data) {
            if (!is_array($data) || empty($data['id'])) {
                $needsPage = true;

                break;
            }
        }

        $page = null;
        if ($needsPage) {
            $urlSegment = trim((string) $input->getOption('url-segment'));

            if ($urlSegment === '') {
                $output->writeln('<error>--url-segment is required to append new blocks (no default page is assumed).</error>');

                return Command::FAILURE;
            }

            $page = SiteTree::get()->filter('URLSegment', $urlSegment)->first();

            if (!$page || !$page->hasMethod('ElementalArea') || !$page->ElementalArea()->exists()) {
                $output->writeln(sprintf('<error>Page "%s" or its ElementalArea not found.</error>', $urlSegment));

                return Command::FAILURE;
            }

            $allowedElements = $page->config()->get('allowed_elements');
            if (is_array($allowedElements) && !in_array(ElementContent::class, $allowedElements, true)) {
                $output->writeln(sprintf('<error>%s does not allow ElementContent blocks (see its "allowed_elements" config).</error>', $page->ClassName));

                return Command::FAILURE;
            }
        }

        $dryRun = (bool) $input->getOption('dry-run');
        $publish = (bool) $input->getOption('publish');
        $config = HTMLEditorConfig::get('cms');
        $allowedClasses = self::getAllowedStyleClasses($config);
        $imported = 0;

        foreach ($blocks as $data) {
            if (!is_array($data)) {
                continue;
            }

            $id = (int) ($data['id'] ?? 0);

            if ($id) {
                $element = ElementContent::get()->byID($id);

                if (!$element) {
                    $output->writeln(sprintf('<error>ElementContent #%d not found.</error>', $id));

                    continue;
                }
            } else {
                $element = ElementContent::create();
                $element->ParentID = $page->ElementalArea()->ID;
            }

            self::applyFields($element, $data, $output);

            $strippedClasses = [];
            $html = self::sanitiseHtml((string) ($data['html'] ?? ''), $config, $allowedClasses, $strippedClasses);

            if ($dryRun) {
                $output->writeln(sprintf(
                    'Would %s ElementContent #%s%s',
                    $element->isInDB() ? 'update' : 'create',
                    $element->ID ?: 'new',
                    $strippedClasses ? sprintf(' [stripped classes: %s]', implode(', ', array_unique($strippedClasses))) : '',
                ));

                ++$imported;

                continue;
            }

            $element->HTML = $html;

            try {
                $element->write();

                if ($publish) {
                    $element->publishRecursive();
                }
            } catch (\Throwable $e) {
                $output->writeln(sprintf('<error>Failed to save ElementContent #%s: %s</error>', $element->ID ?: 'new', $e->getMessage()));

                continue;
            }

            if ($strippedClasses) {
                $output->writeln(sprintf('<comment>  stripped disallowed classes: %s</comment>', implode(', ', array_unique($strippedClasses))));
            }

            $output->writeln(sprintf('  ElementContent #%d', $element->ID));
            ++$imported;
        }

        $output->writeln(sprintf('%s %d content block(s).', $dryRun ? '[dry-run] Would import' : 'Imported', $imported));

        return Command::SUCCESS;
    }

    /** Sets BaseElement/ElementExtension fields present in $data (array_key_exists), leaving anything omitted untouched; invalid enum values are warned about and skipped. */
    private static function applyFields(ElementContent $element, array $data, PolyOutput $output): void
    {
        if (array_key_exists('title', $data)) {
            $element->Title = (string) $data['title'];
        }

        if (array_key_exists('show_title', $data)) {
            $element->ShowTitle = (int) (bool) $data['show_title'];
        }

        if (array_key_exists('is_full_width', $data)) {
            $element->isFullWidth = (int) (bool) $data['is_full_width'];
        }

        if (array_key_exists('title_level', $data)) {
            $titleLevel = (string) $data['title_level'];
            $allowedTitleLevels = self::getAllowedTitleLevels();

            if (in_array($titleLevel, $allowedTitleLevels, true)) {
                $element->TitleLevel = $titleLevel;
            } else {
                $output->writeln(sprintf('<comment>  ignoring invalid title_level "%s" (must be one of: %s)</comment>', $titleLevel, implode(', ', $allowedTitleLevels)));
            }
        }

        if (array_key_exists('background_color', $data)) {
            $backgroundColor = (string) $data['background_color'];
            $allowedBackgroundColors = self::getAllowedBackgroundColors();

            if (in_array($backgroundColor, $allowedBackgroundColors, true)) {
                $element->BackgroundColor = $backgroundColor;
            } else {
                $output->writeln(sprintf('<comment>  ignoring invalid background_color "%s" (must be one of: %s)</comment>', $backgroundColor, implode(', ', $allowedBackgroundColors)));
            }
        }
    }

    /** Sanitises $rawHtml against $config's allowed elements/attributes, then restricts any "class" attribute to $allowedClasses, collecting removed class names into $strippedClasses. */
    private static function sanitiseHtml(string $rawHtml, HTMLEditorConfig $config, array $allowedClasses, array &$strippedClasses): string
    {
        $htmlValue = HTMLValue::create($rawHtml);

        HTMLEditorSanitiser::create($config)->sanitise($htmlValue);

        foreach ($htmlValue->query('//body//*[@class]') as $element) {
            $classes = preg_split('/\s+/', trim($element->getAttribute('class')), -1, PREG_SPLIT_NO_EMPTY);
            $kept = array_intersect($classes, $allowedClasses);
            $strippedClasses = array_merge($strippedClasses, array_diff($classes, $allowedClasses));

            if ($kept) {
                $element->setAttribute('class', implode(' ', $kept));
            } else {
                $element->removeAttribute('class');
            }
        }

        return $htmlValue->getContent();
    }

    /** Flattens TinyMCEConfig's style_formats (see $styles in app/_config.php) into the list of "class" values they allow. */
    private static function getAllowedStyleClasses(HTMLEditorConfig $config): array
    {
        if (!$config instanceof TinyMCEConfig) {
            return [];
        }

        $classes = [];
        foreach ((array) $config->getOption('style_formats') as $style) {
            $class = $style['attributes']['class'] ?? null;

            if ($class) {
                $classes = array_merge($classes, preg_split('/\s+/', trim((string) $class), -1, PREG_SPLIT_NO_EMPTY));
            }
        }

        return array_values(array_unique($classes));
    }

    /** Lists the element names (including patterns like "s*n") allowed by $config's element rule set. */
    private static function getAllowedElementNames(HTMLEditorConfig $config): array
    {
        $names = array_map(
            static fn (HTMLEditorElementRule $rule): string => $rule->getName(),
            $config->getElementRuleSet()->getElementRules(),
        );

        sort($names);

        return $names;
    }

    /** Reads BaseElement.TitleLevel's DB enum values directly, instead of duplicating them here. */
    private static function getAllowedTitleLevels(): array
    {
        $titleLevel = ElementContent::singleton()->dbObject('TitleLevel');

        return $titleLevel instanceof DBEnum ? array_values($titleLevel->enumValues()) : [];
    }

    /** Reads ElementExtension.background_colors config directly, instead of duplicating the ColorPaletteField palette here. */
    private static function getAllowedBackgroundColors(): array
    {
        return array_keys((array) Config::inst()->get(ElementExtension::class, 'background_colors'));
    }
}
