<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\SiteConfig\SiteConfig;
use Kraftausdruck\Extensions\KlaroSiteConfigExtension;
use App\Models\EditableFormField\EditableCheckboxTerms;
use SilverStripe\SpamProtection\EditableSpamProtectionField;

class ElementUserFormsExtension extends DataExtension
{

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'isFullWidth'
        ]);
    }

    public function populateDefaults()
    {
        $termsField = new EditableCheckboxTerms();
        $this->owner->Fields()->add($termsField);

        $spamProtectionField = new EditableSpamProtectionField([
            'Name' => 'SpamProtection',
            'Title' => _t(__CLASS__ . '.DefaultTitle', '')
        ]);
        $this->owner->Fields()->add($spamProtectionField);
    }
}
