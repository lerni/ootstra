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
            } else {
                $loc = Location::get()->filter('Title', $arguments['Title'])->first();
            }
            if ($loc) {
                if ($arguments['Field'] == 'TelLink') {
                    return '<a href="tel:' . $loc->dbObject('Telephone')->TelEnc() . '">' . $loc->Telephone . '</a>';
                }
                if ($arguments['Field'] == 'EMailLink') {
                    return '<a href="mailto:' . $loc->EMail . '">' . $loc->EMail . '</a>';
                }
                if ($loc->hasField($arguments['Field']) &&
                    get_class($loc->dbObject($arguments['Field'])) == 'SilverStripe\ORM\FieldType\DBText') {
                    return nl2br($loc->{$arguments['Field']});
                } else {
                    return $loc->{$arguments['Field']};
                }
            }
        }
        return false;
    }
}
