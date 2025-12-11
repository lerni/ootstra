<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Control\ContentNegotiator;

class PageExtension extends Extension
{
    public function updateMetaComponents(array &$tags)
    {
        $charset = ContentNegotiator::config()->uninherited('encoding');
        $tags['contentType'] = [
            'attributes' => [
                'charset' => $charset
            ]
        ];
    }
}
