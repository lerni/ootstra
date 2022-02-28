<?php

namespace Kraftausdruck\Models;
use App\Models\Perso;
use SilverStripe\Assets\Image;
use JonoM\SomeConfig\SomeConfig;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\TemplateGlobalProvider;

class JobDefaults extends DataObject implements TemplateGlobalProvider
{

    use SomeConfig;

    private static $db = [
        'Industry' => 'Varchar',
        'CFA' => 'Varchar'
        // 'OccupationalCategory' => 'Varchar',
        // 'WorkHours' => 'Varchar'
    ];

    private static $has_one = [
        'HeaderImage' => Image::class,
        'ContactPerso' => Perso::class
    ];

    private static $defaults = [];

    private static $table_name = 'JobDefaults';

}
