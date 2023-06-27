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

    private static $defaults = [
        'AvailableGlobally' => 0
    ];

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'isFullWidth',
            'AvailableGlobally'
        ]);
    }

    public function populateDefaults()
    {
        if (class_exists(KlaroSiteConfigExtension::class)) {
            $id = 2;
            $siteConfig = SiteConfig::current_site_config();
            $id = $siteConfig->CookieLinkPrivacyID;
        }

        $termsField = new EditableCheckboxTerms([
            'Name' => 'TermsAndConditions',
            'Title' => _t(__CLASS__ . '.DefaultTitle', 'Ich akzeptiere die <a rel="noopener noreferrer" href="[sitetree_link,id={id}]" target="_blank">AGBs und Datenschutzbestimmungen</a>.', ['id' => $id]),
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
