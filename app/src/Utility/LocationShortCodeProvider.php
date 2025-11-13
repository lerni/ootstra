<?php

namespace App\Utility;

use App\Models\Location;
use SilverStripe\ORM\FieldType\DBText;

class LocationShortCodeProvider
{
    public static function parseLocationShortCodeProvider($arguments, $content = null, $parser = null, $tagName = null)
    {
        if (array_key_exists('Title', $arguments) && array_key_exists('Field', $arguments) && Location::get()->count()) {
            if (is_numeric($arguments['Title'])) {
                $offset = $arguments['Title'] > 1 ? $arguments['Title'] - 1 : 0;
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
                    $loc->dbObject($arguments['Field'])::class == DBText::class) {
                    return nl2br($loc->{$arguments['Field']});
                }
                return $loc->{$arguments['Field']};
            }
        }
        return false;
    }
}
