<?php

namespace App\Utility;

use SilverStripe\Core\Environment;
use Intervention\Image\ImageManager;
use Jcupitt\Vips\Config as VipsConfig;
use SilverStripe\Core\Injector\Factory;
use SilverStripe\Core\Injector\Injector;
use Intervention\Image\Drivers\Vips\Driver as VipsDriver;

// Replaces InterventionManagerFactory to avoid a TypeError in Config::prepareOptions()
// when Silverstripe's Injector merges constructor args as integer-keyed array entries.
class ImageManagerFactory implements Factory
{
    public function create(string $service, array $params = []): ImageManager
    {
        $driver = Injector::inst()->create('InterventionImageDriver');

        // One thread per core exhausts the web process limits on shared hosting (glib "Error creating thread").
        // .env is not exported to the C environment, so libvips never sees VIPS_CONCURRENCY from there.
        $threads = (int) (Environment::getEnv('VIPS_CONCURRENCY') ?: 1);
        if ($driver instanceof VipsDriver && $threads > 0) {
            VipsConfig::concurrencySet($threads);
        }

        return new ImageManager($driver, autoOrientation: true);
    }
}
