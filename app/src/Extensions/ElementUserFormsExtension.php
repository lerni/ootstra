<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use App\Models\EditableFormField\EditableCheckboxTerms;
use SilverStripe\SpamProtection\EditableSpamProtectionField;

/**
 * @extends Extension<\DNADesign\ElementalUserForms\Model\ElementForm>
 */
class ElementUserFormsExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'isFullWidth',
        ]);
    }

    public function onAfterPopulateDefaults()
    {
        $termsField = EditableCheckboxTerms::create();
        $this->getOwner()->Fields()->add($termsField);

        $spamProtectionField = EditableSpamProtectionField::create([
            'Name' => 'SpamProtection',
            'Title' => _t(self::class . '.DefaultTitle', ''),
        ]);
        $this->getOwner()->Fields()->add($spamProtectionField);
    }
}
