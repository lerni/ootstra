<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

class ElementContentExtension extends Extension
{

    private static $db = [
        'WidthReduced' => 'Boolean',
        'PushUP' => 'Int'
    ];

    private static $defaults = [
        'WidthReduced' => 1
    ];

    public function updateCMSFields(FieldList $fields)
    {

        $fields->removeByName('isFullWidth');

        if ($WidthReducedBox = $fields->dataFieldByName('WidthReduced')) {
            $WidthReducedBox->setTitle(_t('DNADesign\Elemental\Models\BaseElement.WIDTHREDUCED', 'reduce width'));
            $fields->addFieldToTab('Root.Settings', $WidthReducedBox);
        }

        if ($PushUPField = $fields->dataFieldByName('PushUP')) {
            $PushUPField->setTitle(_t('DNADesign\Elemental\Models\BaseElement.PUSHUP', 'Nach oben verschieben'));
            $PushUPField->setDescription(_t('DNADesign\Elemental\Models\BaseElement.SpacingDescription', 'none'));
            $fields->addFieldToTab('Root.Settings', $PushUPField);
        }

        if ($TextEditor = $fields->dataFieldByName('HTML')) {
            $TextEditor->setRows(30);
            $width_reduced = $this->owner->WidthReduced ? ' width-reduced' : '';
            $TextEditor->getEditorConfig()->setOption('body_class', 'typography '. $this->owner->ShortClassName($this, true) . ' background--' . $this->owner->BackgroundColor . $width_reduced);
        }
    }
}
