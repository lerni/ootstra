<?php

namespace App\Extensions;

use SilverStripe\Forms\Form;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\HiddenField;
use SilverStripe\ORM\CMSPreviewable;

/**
 * The CMS preview panel's "follow navigation" JS (LeftAndMain.Preview.js:_loadCurrentPage) detects
 * that the previewed record changed by comparing the iframe's x-page-id meta tag against the edit
 * form's `input[name=ID]` value - but GridFieldDetailForm_ItemRequest never adds such a field (unlike
 * SiteTree's CMSMain edit form). Without it, the preview never auto-follows into GridField-edited records.
 *
 * @extends Extension<\SilverStripe\Forms\GridField\GridFieldDetailForm_ItemRequest>
 */
class GridFieldDetailFormIDFieldExtension extends Extension
{
    protected function updateItemEditForm(Form $form): void
    {
        $record = $this->getOwner()->getRecord();
        if (($record instanceof CMSPreviewable || $record->hasExtension(CMSPreviewable::class))
            && !$form->Fields()->dataFieldByName('ID')
        ) {
            $form->Fields()->push(HiddenField::create('ID', null, $record->ID));
        }
    }
}
