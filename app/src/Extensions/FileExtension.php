<?php

namespace App\Extensions;

use SilverStripe\Assets\Image;
use SilverStripe\Core\Extension;

class FileExtension extends Extension
{
    private static $db = [
        'Caption' => 'Text',
    ];

    public function Orientation(): string
    {
        $owner = $this->getOwner();
        if (!$owner instanceof Image || !$owner->exists()) {
            return '';
        }
        $width = $owner->getWidth();
        $height = $owner->getHeight();
        if ($width > $height) {
            return 'landscape';
        }

        if ($width < $height) {
            return 'portrait';
        }

        return 'square';
    }
}
