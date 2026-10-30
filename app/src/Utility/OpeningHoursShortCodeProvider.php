<?php

namespace App\Utility;

use SilverStripe\SiteConfig\SiteConfig;

class OpeningHoursShortCodeProvider
{
    /**
     * [OpeningHours Days="cccc"], Days is an ICU weekday pattern: ccc (Mo), cccc (Montag), ccccc (M), cccccc (Mo)
     */
    public static function parseOpeningHoursShortCodeProvider($arguments, $content = null, $parser = null, $tagName = null)
    {
        $dayFormat = in_array($arguments['Days'] ?? '', ['ccc', 'cccc', 'ccccc', 'cccccc'], true) ? $arguments['Days'] : 'ccc';

        return SiteConfig::current_site_config()->OpeningHoursHTML($dayFormat) ?? false;
    }
}
