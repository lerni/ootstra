<?php

namespace App\Extensions;

use SilverStripe\ORM\DataExtension;
use gorriecoe\Robots\Robots;
use SilverStripe\Assets\Folder;

class RobotsFoldersExtension extends DataExtension
{
    public function updateDisallowedUrls(&$urls)
    {
        if (Robots::config()->disallow_unsearchable) {
            $blockingFolders = Folder::get()->filter(['ShowInSearch' => 0]);
            foreach ($blockingFolders as $folder) {
                $urls[] = '/assets/'. $folder->getFilename();
            }
        }
    }
}
