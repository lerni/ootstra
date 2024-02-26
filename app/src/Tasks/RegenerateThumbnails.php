<?php

namespace App\Tasks;

use SilverStripe\ORM\DB;
use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;

class RegenerateThumbnails extends BuildTask
{
    protected $title = 'Regenerate image thumnbnails';

    protected $description = 'Run per CLI to regenerate thumbnails for all images.';

    protected $enabled = true;

    public function run($request)
    {
        $images = Image::get();
        foreach ($images as $image) {
            AssetAdmin::singleton()->generateThumbnails($image);
            DB::alteration_message("Create thumbnails for $image->Title");
        }
    }
}
