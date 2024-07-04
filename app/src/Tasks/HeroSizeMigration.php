<?php

namespace App\Tasks;

use Exception;
use SilverStripe\ORM\DB;
use SilverStripe\Dev\BuildTask;

class HeroSizeMigration extends BuildTask
{
    protected $description = 'renames fields to HeroSize';
    private static $segment = 'rename-herosize';

    public function run($request)
    {
        $this->updateHeroSize();
    }

    // php ./vendor/silverstripe/framework/cli-script.php dev/tasks/rename-herosize
    function updateHeroSize()
    {
        $tableToAlter = [
            'ElementHero',
            'ElementHero_Live',
            'ElementHero_Versions',
            'Blog',
            'Blog_Live',
            'Blog_Versions',
            'JobDefaults'
        ];

        foreach($tableToAlter as $table) {
            // https://github.com/wilr/silverstripe-tasker/blob/master/src/Traits/TaskHelpers.php#L454
            DB::alteration_message("Altering table $table");
            try {
                DB::query('ALTER TABLE ' . $table . ' CHANGE Size HeroSize ENUM(\'medium\')');
                DB::alteration_message("Alter column in $table from Size to HeroSize");
            } catch (Exception $e) {
                DB::alteration_message("Failed to alter column in $table: " . $e->getMessage());
                return false;
            }
        }
    }
}
