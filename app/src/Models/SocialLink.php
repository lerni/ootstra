<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Url' => 'Varchar',
        'Icon' => 'Enum("f,F,b,i,I,n,N,x,X,t,T,y,Y,p,m,l,L,g")',
        'sameAs' => 'Boolean'
    ];

    // Facebook			f,F,b
    // Insta			i,I
    // LinkedIn			n,N
    // Xing				X,X
    // Twitter			t,T
    // Youtube			y,Y
    // phone			p
    // mail				m
    // marker lat/lng	l,L

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

    private static $translate = [
        'Url'
    ];

    private static $defaults = [
        'sameAs' => 1
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Text'] = _t(__CLASS__ . '.TEXT', 'Text');
        $labels['sameAs'] = _t(__CLASS__ . '.sameAs', '"sameAs" in schema verwenden');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($IconField = $fields->dataFieldByName('Icon')) {
            $IconField->setEmptyString('---');
        }

        return $fields;
    }
}
