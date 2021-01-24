<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Url' => 'Varchar',
        'Icon' => 'Enum("f,d,e,i,h,n,k,x,r,t,o,y,q,p,m,l,s")',
        'sameAs' => 'Boolean'
    ];

    // Facebook			f,d,e
    // Insta 			i,h
    // LinkedIn			n,k
    // Xing				x,r
    // Twitter			t,o
    // Youtube 			y,q
    // phone 			p
    // mail				m
    // marker lat/lng	l,s

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
