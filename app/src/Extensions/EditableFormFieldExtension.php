<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Versioned\Versioned;
use DNADesign\ElementalUserForms\Model\ElementForm;
use SilverStripe\UserForms\Model\EditableFormField;
use App\Models\EditableFormField\EditableCheckboxTerms;
use SilverStripe\SpamProtection\EditableSpamProtectionField;

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

    /**
     * ElementUserFormsExtension::onAfterPopulateDefaults() adds the terms checkbox and spam
     * protection field before any fixture-defined fields exist, so they land at the start of
     * the Sort order. Move them to the end once all fixtures (incl. custom Fields) are loaded.
     */
    public function onAfterPopulateRecords(): void
    {
        foreach (ElementForm::get() as $form) {
            $sort = (int) $form->Fields()->max('Sort');

            foreach ($form->Fields()->sort('Sort') as $field) {
                if (!$field instanceof EditableCheckboxTerms && !$field instanceof EditableSpamProtectionField) {
                    continue;
                }

                $sort++;
                $field->Sort = $sort;
                $field->write();

                if ($field->hasExtension(Versioned::class)) {
                    $field->publishRecursive();
                }
            }
        }
    }
}
