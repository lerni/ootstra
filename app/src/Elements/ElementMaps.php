<?php

namespace App\Elements;

use App\Models\Point;
use SilverStripe\Forms\HeaderField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use App\Controller\ElementMapsController;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

class ElementMaps extends BaseElement
{
    private static $db = [
        'Zoom' => 'Int',
        'MapType' => 'Varchar',
        'Scale' => 'Boolean',
        'Fullscreen' => 'Boolean',
        'StreetView' => 'Boolean',
        'ShowZoom' => 'Boolean',
        'HTML' => 'HTMLText'
    ];

    private static $many_many = [
        'Points' => Point::class
    ];

    private static $many_many_extraFields = [
        'Points' => [
            'SortOrder' => 'Int'
        ]
    ];

    private static $defaults = [
        'Zoom' => 13,
        'MapType' => 'roadmap',
        'Fullscreen' => 1,
        'AvailableGlobally' => 0
    ];

    private static $table_name = 'ElementMaps';

    private static $title = 'Map';

    private static $description = 'Google Map';

    private static $singular_name = 'Map';

    private static $plural_name = 'Maps';

    private static $controller_class = ElementMapsController::class;

    private static $icon = 'font-icon-block-globe';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'AnchorLink',
            'BackgroundColor',
            'Points',
            'WidthReduced'
        ]);

        if ($AvailableGloballyField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableGloballyField->setDisabled(true);
        }

        if ($TextEditorField = $fields->dataFieldByName('HTML')) {
            $TextEditorField->setRows(16);
            $TextEditorField->getEditorConfig()->setOption('body_class', 'typography '. $this->ShortClassName($this, true));
            $TextEditorField->setDescription(_t(__CLASS__ . '.HTMLFieldDescription', 'If content, it \'ll be shown side by side to "map"'));
        }

        $fields->addFieldToTab('Root.Main', new HeaderField('MapSettingsHeader', 'Map settings'));
        $fields->addFieldToTab('Root.Main', new DropdownField('MapType', 'Map type', [
            'roadmap' => 'Roadmap',
            'satellite' => 'Satellite',
            'hybrid' => 'Hybrid',
            'terrain' => 'Terrain'
        ]));

        $ZoomLevels = [];
        for ($i = 1; $i < 20; $i++) {
            $message = ($i == 1) ? "min. Zoom" : "";
            $message = ($i == 19) ? "max. Zoom" : $message;
            $ZoomLevels[$i] = ($message) ? $i . ' - ' . $message : $i;
        }
        $fields->addFieldToTab('Root.Main', $ZoomField = DropdownField::create('Zoom', 'Zoom', $ZoomLevels));
        $ZoomField->setDescription(_t(__CLASS__ . '.ZoomDescription', 'Zoom level adjusts to show all markers. A minimum value can be configured here.'));

        // hack around unsaved relations
        if ($this->isInDB()) {
            $PointGridFieldConfig = GridFieldConfig_Base::create(20);
            $PointGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-left'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right'),
                new GridFieldOrderableRows('SortOrder')
            );
            $PointGridFieldConfig->removeComponentsByType(GridFieldFilterHeader::class);
            $gridField = new GridField('Points', 'Points', $this->Points(), $PointGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField);
        } else {
            $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Map');
    }
}
