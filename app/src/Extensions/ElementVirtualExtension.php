<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

/**
 * @extends Extension<\DNADesign\ElementalVirtual\Model\ElementVirtual>
 */
class ElementVirtualExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'Settings',
            'BackgroundColor',
            'TitleLevel',
        ]);
    }
}
