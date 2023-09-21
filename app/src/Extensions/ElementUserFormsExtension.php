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
        if (class_exists(KlaroSiteConfigExtension::class)) {
            $siteConfig = SiteConfig::current_site_config();
            $id = $siteConfig->CookieLinkPrivacyID;
        } else {
            $id = 2;
        }

        $termsField = new EditableCheckboxTerms([
            'Name' => 'TermsAndConditions',
            'Title' => _t('App\Models\EditableFormField\EditableCheckboxTerms.DefaultTitle', 'I accept <a rel="noopener noreferrer" href="[sitetree_link,id={id}]" target="_blank">Terms & Conditions and Privacy Policy</a>.', ['id' => $id]),
            'Required' => true,
            'ExtraClass' => 'half-width'
        ]);
        $this->owner->Fields()->add($termsField);

        $spamProtectionField = new EditableSpamProtectionField([
            'Name' => 'SpamProtection',
            'Title' => _t(__CLASS__ . '.DefaultTitle', ''),
            'ExtraClass' => 'half-width'
        ]);

        $this->owner->Fields()->add($spamProtectionField);
    }
}
