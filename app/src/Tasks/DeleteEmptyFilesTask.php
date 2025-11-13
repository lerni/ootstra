<?php

namespace App\Tasks;

// credits to Dave Toews

use SilverStripe\Assets\File;
use SilverStripe\Assets\Folder;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Versioned\Versioned;
use SilverStripe\ORM\Queries\SQLDelete;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;

class DeleteEmptyFilesTask extends BuildTask
{
    protected string $title = 'Delete all empty Files';
    protected static string $description = 'This task removes all entries from `File` table where `FileFilename IS NULL and not a folder. This task might timeout, if it does; then simply refresh the page to rerun it.';

    protected function execute(InputInterface $input, PolyOutput $output): int
    {

        $files = File::get()->filter(['ClassName:not' => Folder::class, 'FileFilename' => NULL])->sort('ID');

        foreach ($files as $file) {
            // set_time_limit(20); // hopefull attempt to prevent timeout, but if it does; then simply refresh the page to run the task again
            $output->writeln('Found record ID: ' . $file->ID . ', Title: ' . $file->Title);
            $file->doUnpublish();
            $file->deleteFile();
            $file->deleteFromStage(Versioned::DRAFT);
            $file->deleteFromStage(Versioned::LIVE);

            // we also need to delete from the versions table
            $query = SQLDelete::create()
                ->setFrom('"File_Versions"')
                ->setWhere("RecordID", $file->ID);

            $result = $query->execute();
        }

        return Command::SUCCESS;
    }
}
