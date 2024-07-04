<?php

namespace App\Tasks;

use SilverStripe\ORM\DB;
use SilverStripe\Dev\BuildTask;

// like hamaka/userforms-cleanupsubmissions,
// with the addition of making targeting classes configurable

class CleanUpObjects extends BuildTask
{
    protected $title = "Clean-up Task";

    protected $description = 'Cleans-up Object as configured per "App\Tasks\CleanUpObjects > objects_to_clean_up" & "App\Tasks\CleanUpObjects > days_retention"';

    private static $segment = 'cleanup-objects';

    private static $days_retention = 180;

    public function run($request)
    {
        $iThresholdDate = strtotime('-' . $this->config()->get('days_retention') . ' days');
        $sThresholdDate = date('Y-m-d 00:00:00', $iThresholdDate);

        // $ObjClasses = $this->getClasses();
        $ObjClasses = $this->config()->get('objects_to_clean_up');
        DB::alteration_message("***************");
        foreach ($ObjClasses as $ObjClass) {
            DB::alteration_message('Removing all ' . $ObjClass . ' before ' . $sThresholdDate);
            DB::alteration_message('Total entries in database (before cleanup): ' . $ObjClass::get()->count());
            $iClearedEntries = $this->cleanUpObject($sThresholdDate, $ObjClass);
            DB::alteration_message('Total entries to be deleted: ' . $iClearedEntries);
            DB::alteration_message("Done, total entries left after cleanup: " . $ObjClass::get()->count());
            DB::alteration_message("***************");
        }
    }

    public static function cleanUpObject(string $sBeforeDate, string $class): int
    {
        $obj = $class::get()->filter('Created:LessThanOrEqual', $sBeforeDate);
        $iTotalToBeCleared = $obj->count();
        $obj->removeAll();

        return $iTotalToBeCleared;
    }
}
