<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\UserForms\Model\EditableFormField;

/**
 * @extends Extension<object>
 */
class EditableFormFieldExtension extends Extension
{
    public function onAfterPopulateDefaults(): void
    {
        $owner = $this->getOwner();

        if (!$owner instanceof EditableFormField) {
            return;
        }

        if ($owner->config()->get('literal')) {
            return;
        }

        $owner->ExtraClass = 'half-width';
    }
}
