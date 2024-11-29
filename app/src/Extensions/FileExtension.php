<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

class FileExtension extends Extension
{
    private static $db = [
        'Caption' => 'Text'
    ];
}
