<?php

namespace App\Utility;

use App\Models\Location;

class LocationShortCodeProvider
{
    public static function parseLocationShortCodeProvider($arguments, $content = null, $parser = null, $tagName = null)
    {
        if (array_key_exists('Title', $arguments) && array_key_exists('Field', $arguments) && Location::get()->count()) {
            if (is_numeric($arguments['Title'])) {
                if ($arguments['Title'] > 1) {
                    $offset = $arguments['Title'] - 1;
                } else {
                    $offset = 0;
                }
                $loc = Location::get()->limit(1, $offset)->first();
            }
            return $loc->{$arguments['Field']};
        } else {
            $loc = Location::get()->filter('Title', $arguments['Title'])->first();
        }
    }
}
