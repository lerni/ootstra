<?php

namespace App\Tasks;

use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\PolyExecution\PolyOutput;
use Symfony\Component\Console\Command\Command;
use SilverStripe\AssetAdmin\Controller\AssetAdmin;
use Symfony\Component\Console\Input\InputInterface;

class RegenerateThumbnails extends BuildTask
{
    protected string $title = 'Regenerate image thumnbnails';

    protected static string $description = 'Run per CLI to regenerate thumbnails for all images.';

    protected $enabled = true;

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $images = Image::get();
        foreach ($images as $image) {
            AssetAdmin::singleton()->generateThumbnails($image);
            $output->writeln("Create thumbnails for $image->Title");
        }

        return Command::SUCCESS;
    }
}
