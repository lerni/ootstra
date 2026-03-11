<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\UserForms\Model\EditableFormField\EditableFormHeading;

/**
 * @extends Extension<object>
 */
class EditableFormFieldExtension extends Extension
{
    public function onAfterPopulateDefaults(): void
    {
        if ($this->getOwner() instanceof EditableFormHeading) {
            return;
        }

        $this->getOwner()->ExtraClass = 'half-width';
    }
}
