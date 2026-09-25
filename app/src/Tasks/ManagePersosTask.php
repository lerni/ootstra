<?php

namespace App\Tasks;

use App\Models\Perso;
use App\Models\Department;
use App\Elements\ElementPerso;
use App\Util\ImageUrlResolver;
use App\Elements\ElementPersoCFA;
use SilverStripe\CMS\Model\SiteTree;
use Kraftausdruck\Tasks\McpBuildTask;
use Kraftausdruck\Utility\AssetImporter;
use SilverStripe\PolyExecution\PolyOutput;
use DNADesign\Elemental\Models\BaseElement;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Reusable create/update/attach of people (name, position, bio, portrait URL) into Perso
 * records, attached to an ElementPerso or ElementPersoCFA block on a chosen page.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-persos --url-segment=home --data=@/path/to/persos.json
 */
class ManagePersosTask extends McpBuildTask
{
    protected static string $commandName = 'manage-persos';

    protected string $title = 'Manage Persos';

    protected static string $description = 'Creates/updates Perso records from a JSON array (name, position, bio, img, department, email, telephone) and attaches them to an ElementPerso/ElementPersoCFA block on the given page.';

    /** @var array<string,class-string<BaseElement>> */
    private static array $element_classes = [
        'ElementPerso' => ElementPerso::class,
        'ElementPersoCFA' => ElementPersoCFA::class,
    ];

    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, 'JSON array of people: [{"name","position","bio","img","department","email","telephone"}, ...]. "department" is an optional existing Department.Title to associate the person with. Prefix with @ to read from a file.'),
            new InputOption('url-segment', null, InputOption::VALUE_REQUIRED, 'URLSegment of the page to attach the block to', 'home'),
            new InputOption('element-class', null, InputOption::VALUE_REQUIRED, 'Block type to add to: ElementPerso or ElementPersoCFA', 'ElementPerso'),
            new InputOption('element-id', null, InputOption::VALUE_REQUIRED, 'Existing block ID to add to (optional — otherwise reuses/creates one of --element-class on the page)'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Preview without writing to the database'),
        ]);
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $rawData = (string) $input->getOption('data');
        if (str_starts_with($rawData, '@')) {
            $rawData = (string) file_get_contents(substr($rawData, 1));
        }

        $people = json_decode($rawData, true);
        if (!is_array($people) || !$people) {
            $output->writeln('<error>--data must be a non-empty JSON array of {name, position, bio, img} objects.</error>');

            return Command::FAILURE;
        }

        $urlSegment = (string) ($input->getOption('url-segment') ?: 'home');
        $page = SiteTree::get()->filter('URLSegment', $urlSegment)->first();

        if (!$page || !$page->hasMethod('ElementalArea') || !$page->ElementalArea()->exists()) {
            $output->writeln(sprintf('<error>Page "%s" or its ElementalArea not found.</error>', $urlSegment));

            return Command::FAILURE;
        }

        $elementClassName = (string) ($input->getOption('element-class') ?: 'ElementPerso');
        $elementClass = self::$element_classes[$elementClassName] ?? null;

        if (!$elementClass) {
            $output->writeln(sprintf('<error>--element-class must be one of: %s</error>', implode(', ', array_keys(self::$element_classes))));

            return Command::FAILURE;
        }

        $elementId = (int) $input->getOption('element-id');
        $dryRun = (bool) $input->getOption('dry-run');

        if ($elementId) {
            $element = BaseElement::get()->byID($elementId);

            if (!$element || !($element instanceof $elementClass)) {
                $output->writeln(sprintf('<error>%s #%d not found.</error>', $elementClassName, $elementId));

                return Command::FAILURE;
            }
        } else {
            $element = $elementClass::get()->filter('ParentID', $page->ElementalArea()->ID)->first();

            if (!$element) {
                $element = $elementClass::create();
                $element->ParentID = $page->ElementalArea()->ID;
                $element->Sorting = 'manual';
                if ($element->hasField('CountMax')) {
                    $element->CountMax = count($people);
                }
            }
        }

        if ($dryRun) {
            $wouldImport = 0;
            foreach ($people as $data) {
                $name = trim((string) ($data['name'] ?? ''));

                if (!$name) {
                    $output->writeln('<error>Skipping entry without "name".</error>');

                    continue;
                }

                $output->writeln(sprintf('Would import: %s (%s)', $name, $data['position'] ?? ''));
                ++$wouldImport;
            }
            $output->writeln(sprintf('[dry-run] %d people would be added to %s #%s.', $wouldImport, $elementClassName, $element->ID ?: 'new'));

            return Command::SUCCESS;
        }

        $element->write();

        $sortField = array_key_first((array) ($element->config()->get('many_many_extraFields')['Persos'] ?? [])) ?: 'SortOrder';
        $sort = (int) $element->Persos()->count();
        $imported = 0;

        foreach ($people as $data) {
            $name = trim((string) ($data['name'] ?? ''));

            if (!$name) {
                $output->writeln('<error>Skipping entry without "name".</error>');

                continue;
            }

            [$firstname, $lastname] = array_pad(explode(' ', $name, 2), 2, '');

            try {
                $perso = Perso::get()->filter(['Firstname' => $firstname, 'Lastname' => $lastname])->first();

                if (!$perso) {
                    $perso = Perso::create();
                }

                $perso->Firstname = $firstname;
                $perso->Lastname = $lastname;
                $perso->Position = (string) ($data['position'] ?? '');
                $perso->Motivation = (string) ($data['bio'] ?? '');
                $perso->EMail = (string) ($data['email'] ?? '');
                $perso->Telephone = (string) ($data['telephone'] ?? '');
                $perso->write();

                $imgUrl = (string) ($data['img'] ?? '');
                if (!$perso->Portrait()->exists() && $imgUrl) {
                    $this->attachPortrait($perso, $imgUrl, $output);
                }

                $department = $this->attachToDepartment($perso, (string) ($data['department'] ?? ''), $output);

                $element->Persos()->add($perso, [$sortField => ++$sort]);
            } catch (\Throwable $e) {
                $output->writeln(sprintf('<error>Failed to save "%s": %s</error>', $name, $e->getMessage()));

                continue;
            }

            $output->writeln(sprintf('  %s (Perso #%d)%s', $name, $perso->ID, $department ? " [{$department}]" : ''));
            ++$imported;
        }

        $output->writeln(sprintf('Imported %d people into %s #%d.', $imported, $elementClassName, $element->ID));

        return Command::SUCCESS;
    }

    /** Adds $perso to the Department named $title, if given and found — warns (never creates) if not found. */
    private function attachToDepartment(Perso $perso, string $title, PolyOutput $output): ?string
    {
        if ($title === '') {
            return null;
        }

        $department = Department::get()->filter('Title', $title)->first();

        if (!$department) {
            $output->writeln(sprintf('<comment>  Department "%s" not found — leaving unset.</comment>', $title));

            return null;
        }

        $department->Persos()->add($perso);

        return $title;
    }

    private function attachPortrait(Perso $perso, string $url, PolyOutput $output): void
    {
        $image = AssetImporter::createFromUrl(ImageUrlResolver::resolveOriginal($url), 'Portraits');

        if ($image) {
            $perso->PortraitID = $image->ID;
            $perso->write();
        } else {
            $output->writeln(sprintf('<comment>  Portrait import failed for "%s".</comment>', $url));
        }
    }
}
