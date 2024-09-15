<?php

namespace App\Models\EditableFormField;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\UserForms\Model\EditableFormField;
use Kraftausdruck\Extensions\KlaroSiteConfigExtension;

class EditableCheckboxTerms extends EditableFormField
{
    private static $db = [
        'Title' => 'HTMLText'
    ];

    private static $casting = [
        'Title' => 'HTMLText'
    ];

    private static $defaults = [
        'Required' => 1
    ];

    private static $singular_name = 'Checkbox Terms Field';
    private static $plural_name = 'Terms checkboxes';

    private static $table_name = 'EditableCheckboxTerms';

    private function getKlaroConfigID()
    {
        if (class_exists(KlaroSiteConfigExtension::class)) {
            $siteConfig = SiteConfig::current_site_config();
            $id = $siteConfig->CookieLinkPrivacyID;
        } else {
            $id = 2; // ID we get per default with fixtures
        }
        return $id;
    }

    public function populateDefaults()
    {
        $id = $this->getKlaroConfigID();
        $this->Name = 'TermsAndConditions';
        $this->Title = _t(__CLASS__ . '.DefaultTitle', 'I accept <a rel="noopener noreferrer" href="[sitetree_link,id={id}]" target="_blank">Terms & Conditions and Privacy Policy</a>.', ['id' => $id]);
        $this->Required = true;
        parent::populateDefaults();
    }

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            $id = $this->getKlaroConfigID();
            if ($TitleField = $fields->dataFieldByName('Title')) {
                $TitleField->setDescription(_t(__CLASS__ . '.DefaultDescription', 'I accept &lt;a rel=&quot;noopener noreferrer&quot; href=&quot;[sitetree_link,id={id}]&quot; target=&quot;_blank&quot;&gt;Terms and  Privacy policy&lt;/a&gt;.<br/><strong>{id}</strong> is the PageID which Klaro links.', ['id' => $id]));
            }
        });

        return parent::getCMSFields();
    }

    public function TitleParsed()
    {
        $text = $this->getField('Title');
        return ShortcodeParser::get_active()->parse($text);
    }

    public function getFormField()
    {
        $field = CheckboxField::create($this->Name, $this->Title ?: false)
            // ->setTemplate(EditableCheckboxTerms::class)
            // ->setTemplate('App\Models\EditableFormField\EditableCheckboxTerms')
            // ->setTemplate(__CLASS__)
            ->setFieldHolderTemplate('App\Models\EditableFormField\EditableCheckboxTerms_holder')
            ->setTitle($this->TitleParsed());

        $this->doUpdateFormField($field);

        return $field;
    }
}
