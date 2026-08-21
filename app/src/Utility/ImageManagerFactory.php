<?php

namespace App\Util;

use Intervention\Image\ImageManager;
use SilverStripe\Core\Injector\Factory;
use SilverStripe\Core\Injector\Injector;

// Replaces InterventionManagerFactory to avoid a TypeError in Config::prepareOptions()
// when Silverstripe's Injector merges constructor args as integer-keyed array entries.
class ImageManagerFactory implements Factory
{
    public function create(string $service, array $params = []): ImageManager
    {
        return ImageManager::withDriver(
            Injector::inst()->create('InterventionImageDriver'),
            autoOrientation: true,
        );
    }
}
