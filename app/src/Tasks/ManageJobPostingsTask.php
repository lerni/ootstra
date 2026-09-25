<?php

namespace App\Tasks;

use App\Models\Perso;
use App\Models\Slide;
use App\Models\Location;
use Kraftausdruck\Models\JobPosting;
use Kraftausdruck\Tasks\McpBuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;

/**
 * Reusable create/update of JobPosting records from a JSON array, attaching *existing*
 * ContactPerso (Perso), JobLocations (Location) and Slides (Slide) records by name/title
 * or ID. Never creates Perso, Location or Slide records — only JobPosting itself.
 * Exposed as an MCP tool (see Kraftausdruck\Tasks\McpBuildTask / McpTaskController.allowed_tasks).
 *
 * Run via: php ./vendor/bin/sake tasks:manage-job-postings --data=@/path/to/jobpostings.json
 */
class ManageJobPostingsTask extends McpBuildTask
{
    protected static string $commandName = 'manage-job-postings';

    protected string $title = 'Manage Job Postings';

    protected static string $description = 'Creates/updates JobPosting records from a JSON array and attaches existing ContactPerso, JobLocations and Slides by name/title or ID — never creates new related objects.';

    /** @var array<string,string> JSON key => JobPosting db field */
    private static array $field_map = [
        'title' => 'Title',
        'description' => 'Description',
        'active' => 'Active',
        'industry' => 'Industry',
        'employment_type' => 'EmploymentType',
        'job_location_type' => 'JobLocationType',
        'applicant_location_requirements' => 'ApplicantLocationRequirements',
        'date_posted' => 'DatePosted',
        'valid_through' => 'ValidThrough',
        'workload_min' => 'WorkloadMin',
        'workload_max' => 'WorkloadMax',
        'base_salary_min' => 'BaseSalaryMin',
        'base_salary_max' => 'BaseSalaryMax',
        'base_salary_currency' => 'BaseSalaryCurrency',
        'base_salary_period' => 'BaseSalaryPeriod',
        'hero_size' => 'HeroSize',
        'meta_description' => 'MetaDescription',
    ];

    public function getOptions(): array
    {
        return array_merge(parent::getOptions(), [
            new InputOption('data', null, InputOption::VALUE_REQUIRED, 'JSON array of job postings: [{"title","url_segment","description","active","industry","employment_type","job_location_type","applicant_location_requirements","date_posted","valid_through","workload_min","workload_max","base_salary_min","base_salary_max","base_salary_currency","base_salary_period","hero_size","meta_description","contact_perso","job_locations":[...],"slides":[...]}, ...]. "url_segment" (optional) or "title" identifies an existing JobPosting to update. "contact_perso" is an existing Perso, matched by "Firstname Lastname" or numeric ID. "job_locations"/"slides" are arrays of existing Location/Slide, each matched by Title or numeric ID — unmatched entries are reported and skipped, never created. Any key omitted entirely is left untouched, so JobDefaults-populated values (Industry, ApplicantLocationRequirements, ContactPerso, JobLocations, Slides, salary currency/period, ...) on newly created postings are preserved unless explicitly overridden. Prefix with @ to read from a file.'),
            new InputOption('dry-run', null, InputOption::VALUE_NONE, 'Preview without writing to the database'),
        ]);
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $rawData = (string) $input->getOption('data');
        if (str_starts_with($rawData, '@')) {
            $rawData = (string) file_get_contents(substr($rawData, 1));
        }

        $postings = json_decode($rawData, true);
        if (!is_array($postings) || !$postings) {
            $output->writeln('<error>--data must be a non-empty JSON array of job posting objects.</error>');

            return Command::FAILURE;
        }

        $dryRun = (bool) $input->getOption('dry-run');
        $imported = 0;

        foreach ($postings as $data) {
            if (!is_array($data)) {
                continue;
            }

            $urlSegment = trim((string) ($data['url_segment'] ?? ''));
            $title = trim((string) ($data['title'] ?? ''));

            $jobPosting = null;
            if ($urlSegment !== '') {
                $jobPosting = JobPosting::get()->filter('URLSegment', $urlSegment)->first();
            } elseif ($title !== '') {
                $jobPosting = JobPosting::get()->filter('Title', $title)->first();
            }

            if (!$jobPosting) {
                if ($title === '') {
                    $output->writeln('<error>Skipping entry without "title".</error>');

                    continue;
                }
                $jobPosting = JobPosting::create();
            }

            foreach (self::$field_map as $jsonKey => $dbField) {
                if (!array_key_exists($jsonKey, $data)) {
                    continue;
                }
                $jobPosting->{$dbField} = $jsonKey === 'active' ? (int) (bool) $data[$jsonKey] : $data[$jsonKey];
            }

            $contactPerso = null;
            if (array_key_exists('contact_perso', $data)) {
                $contactPerso = $this->findPerso((string) $data['contact_perso']);
                if (!$contactPerso) {
                    $output->writeln(sprintf('<comment>ContactPerso "%s" not found — leaving unset.</comment>', $data['contact_perso']));
                }
            }

            // Omitting these keys entirely leaves JobDefaults-populated (on create) or existing (on update) relations untouched
            $hasJobLocations = array_key_exists('job_locations', $data);
            $locations = [];
            $missingLocations = [];
            if ($hasJobLocations && is_array($data['job_locations'])) {
                foreach ($data['job_locations'] as $identifier) {
                    $location = $this->findByIdentifier(Location::class, 'Title', $identifier);
                    if ($location) {
                        $locations[] = $location;
                    } else {
                        $missingLocations[] = $identifier;
                    }
                }
            }

            $hasSlides = array_key_exists('slides', $data);
            $slides = [];
            $missingSlides = [];
            if ($hasSlides && is_array($data['slides'])) {
                foreach ($data['slides'] as $identifier) {
                    $slide = $this->findByIdentifier(Slide::class, 'Title', $identifier);
                    if ($slide) {
                        $slides[] = $slide;
                    } else {
                        $missingSlides[] = $identifier;
                    }
                }
            }

            if ($dryRun) {
                $output->writeln(sprintf(
                    'Would %s JobPosting "%s"%s%s%s',
                    $jobPosting->isInDB() ? 'update' : 'create',
                    $title ?: $jobPosting->Title,
                    $contactPerso ? sprintf(' [ContactPerso: %s]', $contactPerso->getTitle()) : '',
                    $locations ? sprintf(' [JobLocations: %s]', implode(', ', array_map(fn ($l) => $l->Title, $locations))) : '',
                    $slides ? sprintf(' [Slides: %s]', implode(', ', array_map(fn ($s) => $s->Title, $slides))) : '',
                ));
                foreach (array_merge($missingLocations, $missingSlides) as $missing) {
                    $output->writeln(sprintf('<comment>  not found, would be skipped: %s</comment>', $missing));
                }

                ++$imported;

                continue;
            }

            if ($contactPerso) {
                $jobPosting->ContactPersoID = $contactPerso->ID;
            }

            try {
                $jobPosting->write();

                if ($hasJobLocations) {
                    $jobPosting->JobLocations()->setByIDList(array_map(fn ($l) => $l->ID, $locations));
                }

                if ($hasSlides) {
                    $jobPosting->Slides()->removeAll();
                    $sort = 0;
                    foreach ($slides as $slide) {
                        $jobPosting->Slides()->add($slide, ['SortOrder' => ++$sort]);
                    }
                }
            } catch (\Throwable $e) {
                $output->writeln(sprintf('<error>Failed to save JobPosting "%s": %s</error>', $title ?: $jobPosting->Title, $e->getMessage()));

                continue;
            }

            foreach (array_merge($missingLocations, $missingSlides) as $missing) {
                $output->writeln(sprintf('<comment>  not found, skipped: %s</comment>', $missing));
            }

            $output->writeln(sprintf('  %s (JobPosting #%d)', $jobPosting->Title, $jobPosting->ID));
            ++$imported;
        }

        $output->writeln(sprintf('%s %d job posting(s).', $dryRun ? '[dry-run] Would import' : 'Imported', $imported));

        return Command::SUCCESS;
    }

    /** Matches an existing Perso by numeric ID or "Firstname Lastname" — never creates one. */
    private function findPerso(string $identifier): ?Perso
    {
        $identifier = trim($identifier);
        if ($identifier === '') {
            return null;
        }

        if (is_numeric($identifier)) {
            return Perso::get()->byID((int) $identifier);
        }

        [$firstname, $lastname] = array_pad(explode(' ', $identifier, 2), 2, '');

        return Perso::get()->filter(['Firstname' => $firstname, 'Lastname' => $lastname])->first();
    }

    /** Matches an existing DataObject by numeric ID or a title field — never creates one. */
    private function findByIdentifier(string $class, string $titleField, mixed $identifier): ?object
    {
        if (is_numeric($identifier)) {
            return $class::get()->byID((int) $identifier);
        }

        return $class::get()->filter($titleField, (string) $identifier)->first();
    }
}
