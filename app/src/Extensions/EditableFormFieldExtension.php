<?php

namespace App\Extensions;

use SilverStripe\ORM\DataExtension;

class EditableFormFieldExtension extends DataExtension
{

    public function populateDefaults()
    {
        $this->owner->ExtraClass = 'half-width';
        parent::populateDefaults();
    }
}
