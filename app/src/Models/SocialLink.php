<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Url' => 'Varchar',
        'Icon' => 'Enum("f,i,n,X,t,y,p,m,l,g")',
        'sameAs' => 'Boolean'
    ];

    //facebook			f
    //insta 			i
    //LinkedIn			n
    //Xing				X
    //twitter			t
    //Youtube 			y
    //phone 			p
    //mail 				m
    //marker lat/lng	l

    private static $has_one = [];

    private static $table_name = 'SocialLink';

    private static $singular_name = 'Social-Link';

    private static $plural_name = 'Social-Links';

    private static $summary_fields = [
        'Title' => 'Titel',
        'Url' => 'Url'
    ];
    private static $searchable_fields = [
        'Title'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Text'] = _t(__CLASS__ . '.TEXT', 'Text');

        return $labels;
    }

    private static $translate = [
        'Url'
    ];

    private static $field_labels = [
        'Title' => 'Titel',
        'sameAs' => '"sameAs" in schema verwenden'
    ];

    private static $defaults = [
        'sameAs' => 1
    ];

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($IconField = $fields->dataFieldByName('Icon')) {
            $IconField->setEmptyString('---');
        }

        return $fields;
    }
}
