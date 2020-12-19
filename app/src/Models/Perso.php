<?php

namespace App\Models;

use App\Models\Department;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\EmailField;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\View\Parsers\URLSegmentFilter;

class Perso extends DataObject
{
    private static $db = [
        'Firstname' => 'Varchar',
        'Lastname' => 'Varchar',
        'Position' => 'Text',
        'EMail' => 'Varchar',
        'Telephone' => 'Varchar',
        'Motivation' => 'HTMLText'
    ];
    private static $has_one = [
        'Portrait' => Image::class
    ];

    private static $belongs_many_many = [
        "Departments" => Department::class
    ];
    //	private static $many_many = [
    //		'SocialLinks' => SocialLink::class
    //	];
    //	private static $many_many_extraFields = [
    //		'SocialLinks' => [
    //			'SortOrder' => 'Int'
    //		]
    //	];

    private static $owns = [
        'Portrait'
    ];

    private static $table_name = 'Perso';

    private static $summary_fields = [
        'Portrait.CMSThumbnail' => 'Thumbnail',
        'Firstname' => 'Vorname',
        'Lastname' => 'Nachname'
    ];

    private static $searchable_fields = [
        'Firstname',
        'Lastname'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Firstname'] = _t(__CLASS__ . '.FIRSTNAME', 'Vorname');
        $labels['Lastname'] = _t(__CLASS__ . '.LASTNAME', 'Nachname');
        $labels['EMail'] = _t(__CLASS__ . '.EMAIL', 'E-Mail');
        $labels['Telephone'] = _t(__CLASS__ . '.TELEPHONE', 'Telefon');
        $labels['Motivation'] = _t(__CLASS__ . '.MOTIVATION', 'Text');

        return $labels;
    }

    private static $translate = [
        'Position',
        'Motivation'
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->replaceField('EMail', EmailField::create('EMail', 'E-Mail'));

        if ($TelephoneField = $fields->dataFieldByName('Telephone')) {
            $TelephoneField->setDescription('+41 43 000 00 00');
        }

        if ($MotivationField = $fields->dataFieldByName('Motivation')) {
            $MotivationField->addExtraClass('stacked');
            $MotivationField->setAttribute('data-mce-body-class', 'persoeditor');
        }

        if ($MAuploadField = $fields->dataFieldByName('Portrait')) {
            $MAuploadField->setFolderName('Portraits');
            $MAuploadField->setDescription('min. 576x766px');
        }
        // $fields->insertAfter($MAuploadField, 'Title');
        $fields->insertBefore($MAuploadField, 'Motivation');

        if ($this->isInDB()) {
            $fields
                ->fieldByName('Root.Departments.Departments')
                ->getConfig()
                ->removeComponentsByType([
                    GridFieldEditButton::class,
                    GridFieldAddNewButton::class
                ]);
        }

        return $fields;
    }

    public function getTitle()
    {
        return $this->Firstname . ' ' . $this->Lastname;
    }

    public function Anchor()
    {
        $filter = new URLSegmentFilter();
        $Sibelings = Perso::get()->exclude("ID", $this->ID);
        $Anchor = $filter->filter($this->Firstname . ' ' . $this->Lastname);
        if ($Sibelings->filter(['Firstname' => $this->Firstname, 'Lastname' => $this->Lastname])->count()) {
            $Anchor = $Anchor . '-' . $this->ID;
        }
        return $Anchor;
    }
}
