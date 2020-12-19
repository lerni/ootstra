<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextareaField;

class FormFileExtension extends Extension
{
    // public function updateForm(Form &$form)
    public function updateFormFields(FieldList $fields)
    {
        // $fields = $form->Fields();
        $CaptionField = TextareaField::create('Caption');
        $editorTab = $fields->findTab('Editor.Details');
        if ($editorTab) {
            //if we have the editor tab, follow the readonly state of the title field
            $titleField = $editorTab->fieldByName('Title');
            $CaptionField->setReadonly($titleField->isReadonly());
            $fields->insertAfter('Title', $CaptionField);
        }
    }
}
