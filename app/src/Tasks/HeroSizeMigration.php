<?php

namespace App\Tasks;

use Exception;
use SilverStripe\ORM\DB;
use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

class HeroSizeMigration extends BuildTask
{
    protected string $title = 'Hero Size Migration';
    protected static string $description = 'renames fields to HeroSize';
    private static $segment = 'rename-herosize';

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        return $this->updateHeroSize($output);
    }

    // php ./vendor/bin/sake dev/tasks/rename-herosize
    public function updateHeroSize(PolyOutput $output): int
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
            $output->writeln("Altering table $table");
            try {
                DB::query('ALTER TABLE ' . $table . ' CHANGE Size HeroSize ENUM(\'medium\')');
                $output->writeln("Alter column in $table from Size to HeroSize");
            } catch (Exception $e) {
                $output->writeln("Failed to alter column in $table: " . $e->getMessage());
                return Command::FAILURE;
            }
        }

        return Command::SUCCESS;
    }
}
