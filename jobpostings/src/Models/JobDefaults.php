<?php

namespace Kraftausdruck\Models;

use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;


class JobDefaults extends DataObject
{
    private static $db = [
        'Idustrie' => 'Varchar',
//         'OccupationalCategory' => 'Varchar',
//         'WorkHours' => 'Varchar'
    ];

    private static $has_one = [
        'HeaderImage' => Image::class
    ];

    private static $defaults = [];

    private static $table_name = 'JobDefaults';

}
