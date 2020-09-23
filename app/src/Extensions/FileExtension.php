<?php

namespace App\Extensions;

use SilverStripe\ORM\DataExtension;

class FileExtension extends DataExtension
{
    private static $db = [
        'Caption' => 'Varchar'
    ];
}
