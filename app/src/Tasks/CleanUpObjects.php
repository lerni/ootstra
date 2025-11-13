<?php

namespace App\Tasks;

use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

// like hamaka/userforms-cleanupsubmissions,
// with the addition of making targeting classes configurable

class CleanUpObjects extends BuildTask
{
    protected string $title = "Clean-up Task";

    protected static string $description = 'Cleans-up Object as configured per "App\Tasks\CleanUpObjects > objects_to_clean_up" & "App\Tasks\CleanUpObjects > days_retention"';

    private static $segment = 'cleanup-objects';

    private static $days_retention = 180;

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $iThresholdDate = strtotime('-' . $this->config()->get('days_retention') . ' days');
        $sThresholdDate = date('Y-m-d 00:00:00', $iThresholdDate);

        // $ObjClasses = $this->getClasses();
        $ObjClasses = $this->config()->get('objects_to_clean_up');
        $output->writeln("***************");
        foreach ($ObjClasses as $ObjClass) {
            $output->writeln('Removing all ' . $ObjClass . ' before ' . $sThresholdDate);
            $output->writeln('Total entries in database (before cleanup): ' . $ObjClass::get()->count());
            $iClearedEntries = $this->cleanUpObject($sThresholdDate, $ObjClass);
            $output->writeln('Total entries to be deleted: ' . $iClearedEntries);
            $output->writeln("Done, total entries left after cleanup: " . $ObjClass::get()->count());
            $output->writeln("***************");
        }

        return Command::SUCCESS; // Return success constant
    }

    public static function cleanUpObject(string $sBeforeDate, string $class): int
    {
        $obj = $class::get()->filter('Created:LessThanOrEqual', $sBeforeDate);
        $iTotalToBeCleared = $obj->count();
        $obj->removeAll();

        return $iTotalToBeCleared;
    }
}
