<?php

namespace Kraftausdruck\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use JonoM\SomeConfig\SomeConfig;
use SilverStripe\View\TemplateGlobalProvider;

class JobDefaults extends DataObject implements TemplateGlobalProvider
{

    use SomeConfig;

    private static $db = [
        'Industry' => 'Varchar',
        // 'OccupationalCategory' => 'Varchar',
        // 'WorkHours' => 'Varchar'
    ];

    private static $has_one = [
        'HeaderImage' => Image::class
    ];

    private static $defaults = [];

    private static $table_name = 'JobDefaults';

}
