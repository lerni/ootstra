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
    protected static string $commandName = 'regenerate-thumbnails';

    protected string $title = 'Regenerate image thumbnails';

    protected static string $description = 'Run per CLI to regenerate thumbnails for all images. Use php ./vendor/bin/sake tasks:regenerate-thumbnails';

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
