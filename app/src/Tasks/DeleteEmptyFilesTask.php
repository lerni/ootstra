<?php

// credits to Dave Toews

use SilverStripe\Dev\BuildTask;
use SilverStripe\ORM\Queries\SQLDelete;
use SilverStripe\Assets\File;
use SilverStripe\Versioned\Versioned;

class DeleteEmptyFilesTask extends BuildTask
{
    protected $title = 'Delete all empty Files';
    protected $description = 'This task removes all entries from `File` table where `FileFilename IS NULL and not a folder. This task might timeout, if it does; then simply refresh the page to rerun it.';

    public function run($request)
    {

        $files = File::get()->filter(array('ClassName:not' => "SilverStripe\Assets\Folder", 'FileFilename' => NULL))->sort('ID');

        foreach ($files as $file) {
            // set_time_limit(20); // hopefull attempt to prevent timeout, but if it does; then simply refresh the page to run the task again
            echo '<p>Found record ID: ' . $file->ID . ', Title: ' . $file->Title . '</p>';
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
    }
}
