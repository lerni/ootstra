<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;

class EditableFormFieldExtension extends Extension
{
    public function populateDefaults()
    {
        $this->owner->ExtraClass = 'half-width';
    }
}
