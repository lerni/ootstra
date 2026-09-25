<?php

namespace App\Utility;

use App\Tasks\CleanUpObjects;
use SilverStripe\Core\Config\Config;

class RetentionPeriodShortCodeProvider
{
    // [RetentionPeriod] renders CleanUpObjects.days_retention, so the privacy policy can't drift from the config
    public static function parseRetentionPeriodShortCodeProvider($arguments, $content = null, $parser = null, $tagName = null): string
    {
        $days = (int) Config::inst()->get(CleanUpObjects::class, 'days_retention');

        if ($days < 60) {
            return _t(self::class . '.Days', '{count} days', ['count' => $days]);
        }

        $months = (int) ceil($days / (365.25 / 12));

        return _t(self::class . '.Months', '{count} months', ['count' => $months]);
    }
}
