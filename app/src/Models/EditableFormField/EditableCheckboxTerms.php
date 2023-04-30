<?php

namespace App\Models\EditableFormField;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\CheckboxField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\UserForms\Model\EditableFormField;
use SilverStripe\UserForms\Model\EditableFormField\EditableCheckbox;
use SilverStripe\View\Parsers\ShortcodeParser;
use SilverStripe\View\Parsers\HTMLValue;

class EditableCheckboxTerms extends EditableCheckbox
{
    // private static $db = [
    //     'Title' => 'HTMLText'
    // ];

    private static $casting = [
        'Title' => 'HTMLFragment'
    ];

    private static $defaults = [
        'Required' => 1
    ];

    private static $singular_name = 'Checkbox Terms Field';

    private static $plural_name = 'Terms checkboxes';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function (FieldList $fields) {
            if ($TitleField = $fields->dataFieldByName('Title')) {
                $TitleField->setDescription(_t(__CLASS__ . '.DefaultTitle', 'Ich akzeptiere &lt;a rel=&quot;noopener noreferrer&quot; href=&quot;[sitetree_link,id=10]&quot; target=&quot;_blank&quot;&gt;AGBs und Datenschutzbestimmungen&lt;/a&gt;'));
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
