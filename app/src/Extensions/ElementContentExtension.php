<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

class ElementContentExtension extends Extension
{

    private static $db = [
        'WidthReduced' => 'Boolean',
        'PushUP' => 'Int'
    ];

    private static $defaults = [
        'WidthReduced' => true
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
            $width_reduced = $this->getOwner()->WidthReduced ? ' width-reduced' : '';
            $TextEditor->getEditorConfig()->setOption('body_class', 'typography '. $this->getOwner()->ShortClassName($this->getOwner(), true) . ' background--' . $this->getOwner()->BackgroundColor . $width_reduced);
        }
    }
}
