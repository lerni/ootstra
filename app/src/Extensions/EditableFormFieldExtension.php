<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

class EditableFormFieldExtension extends Extension
{
    public function onAfterPopulateDefaults()
    {
        $this->getOwner()->ExtraClass = 'half-width';
    }
}
