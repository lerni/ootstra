<?php

namespace App\Extensions;

use App\Models\Slide;
use SilverStripe\Blog\Model\Blog;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\LiteralField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class BlogExtension extends DataExtension
{
    private static $db = [
        'Size' => 'Enum("small,medium,fullscreen","small")'
    ];
    private static $many_many = [
        'Slides' => Slide::class
    ];
    private static $many_many_extraFields = [
        'Slides' => [
            'SortOrder' => 'Int'
        ]
    ];
    private static $owns = [
        'Slides'
    ];

    public function populateDefaults()
    {
        $this->owner->PostsPerPage = (int)100;
        parent::populateDefaults();
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeFieldFromTab('Root.Categorisation', 'Tags');

        // hack arround unsaved relations
        if ($this->owner->isInDB()) {
            $SlideGridFieldConfig = GridFieldConfig_Base::create(20);
            $SlideGridFieldConfig->addComponents(
                new GridFieldEditButton(),
                new GridFieldDeleteAction(false),
                new GridFieldDeleteAction(true),
                new GridFieldDetailForm(),
                new GridFieldAddNewButton('toolbar-header-right'),
                new GridFieldAddExistingAutocompleter('toolbar-header-right')
            );
            $SlideGridFieldConfig->addComponent(new GridFieldOrderableRows('SortOrder'));
            $gridField = new GridField('Slides', 'Slides', $this->owner->Slides(), $SlideGridFieldConfig);
            $fields->addFieldToTab('Root.Main', $gridField, 'Content');

            $sizes = singleton(Blog::class)->dbObject('Size')->enumValues();
            $SizeField = DropdownField::create('Size', 'Grösse/Höhe Header', $sizes);
            $SizeField->setDescription('"fullscreen" erfordert "volle Breite"!');
            $fields->addFieldToTab('Root.Main', $SizeField, 'Content', true);
        } else {
            $fields->addFieldToTab("Root.Main", LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'));
        }
    }
}
