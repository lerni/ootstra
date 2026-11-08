<?php

namespace App\Elements;

use App\Models\Point;
use App\Utility\GridFieldHelper;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\DropdownField;
use App\Controller\ElementMapsController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use App\GridField\GridFieldConfig_SortableRelation;

class ElementMaps extends BaseElement
{
    private static $db = [
        'Zoom' => 'Int',
        'MapType' => 'Varchar',
        'Scale' => 'Boolean',
        'Fullscreen' => 'Boolean',
        'StreetView' => 'Boolean',
        'ShowZoom' => 'Boolean',
        'HTML' => 'HTMLText',
    ];

    private static $many_many = [
        'Points' => Point::class,
    ];

    private static $many_many_extraFields = [
        'Points' => [
            'SortOrder' => 'Int',
        ],
    ];

    private static $defaults = [
        'Zoom' => 13,
        'MapType' => 'roadmap',
        'Fullscreen' => true,
        'AvailableGlobally' => false,
    ];

    private static $table_name = 'ElementMaps';

    private static $title = 'Map';

    private static $class_description = 'Google Map';

    private static $singular_name = 'Map';

    private static $plural_name = 'Maps';

    private static $controller_class = ElementMapsController::class;

    private static $icon = 'font-icon-block-globe';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor',
            'Points',
            'isFullWidth',
            'WidthReduced',
        ]);

        if ($AvailableGloballyField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableGloballyField->setDisabled(true);
        }

        if ($TextEditorField = $fields->dataFieldByName('HTML')) {
            $TextEditorField->setRows(16);
            $TextEditorField->getEditorConfig()->setOption('body_class', 'typography '. $this->ShortClassName($this, true));
            $TextEditorField->setDescription(_t(self::class . '.HTMLFieldDescription', 'If content, it \'ll be shown side by side to "map"'));
        }

        $fields->addFieldToTab('Root.Main', HeaderField::create('MapSettingsHeader', 'Map settings'));
        $fields->addFieldToTab('Root.Main', DropdownField::create('MapType', 'Map type', [
            'roadmap' => 'Roadmap',
            'satellite' => 'Satellite',
            'hybrid' => 'Hybrid',
            'terrain' => 'Terrain',
        ]));

        $ZoomLevels = [];
        for ($i = 1; $i < 20; ++$i) {
            $message = ($i === 1) ? "min. Zoom" : "";
            $message = ($i === 19) ? "max. Zoom" : $message;
            $ZoomLevels[$i] = $message !== '' ? $i . ' - ' . $message : $i;
        }
        $fields->addFieldToTab('Root.Main', $ZoomField = DropdownField::create('Zoom', 'Zoom', $ZoomLevels));
        $ZoomField->setDescription(_t(self::class . '.ZoomDescription', 'Zoom level adjusts to show all markers. A minimum value can be configured here.'));

        GridFieldHelper::addIfSaved($fields, $this, fn () => GridField::create('Points', 'Points', $this->Points(), GridFieldConfig_SortableRelation::create('SortOrder')));

        return $fields;
    }

    public function getType()
    {
        return _t(self::class . '.BlockType', 'Map');
    }
}
