<?php

namespace App\Models\EditableFormField;

use SilverStripe\SiteConfig\SiteConfig;
use Kraftausdruck\Controller\KlaroConfigController;
use Kraftausdruck\Extensions\KlaroSiteConfigExtension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableCheckbox;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Parsers\HTMLValue;

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

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            if (class_exists(KlaroSiteConfigExtension::class)) {
                $id = 2;
                $siteConfig = SiteConfig::current_site_config();
                $id = $siteConfig->CookieLinkPrivacyID;
            }
            if ($TitleField = $fields->dataFieldByName('Title')) {
                $TitleField->setDescription(_t(__CLASS__ . '.DefaultTitle', 'Ich akzeptiere die &lt;a rel=&quot;noopener noreferrer&quot; href=&quot;[sitetree_link,id={id}]&quot; target=&quot;_blank&quot;&gt;AGBs und Datenschutzbestimmungen&lt;/a&gt;.<br/>Für <strong>{id}</strong> die PageID der entsprechenden Seite verwenden!', ['id' => $id]));
            }
        });

        return parent::getCMSFields();
    }

    public function TitleParsed() {
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
