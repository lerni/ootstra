<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\RequiredFields;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'IconName' => 'Varchar',
        'Url' => 'Varchar',
        // 'Icon' => 'Enum("f,d,e,i,h,n,k,x,r,t,o,y,q,p,m,l,s")',
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
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['IconName'] = _t(__CLASS__ . '.ICONNAME', 'Icon name');
        $labels['sameAs'] = _t(__CLASS__ . '.SAMEAS', '"sameAs" use in schema');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($TitleField = $fields->dataFieldByName('IconName')) {
            $feathericonURL = 'https://feathericons.com/';
            $TitleField->setDescription(_t(__CLASS__ . '.IconNameDescription', 'Icon names from <a href="{link}" target="_blank">{link}</a>!', [ 'link' => $feathericonURL ]));
        }

        return $fields;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title',
            'IconName'
        ]);
    }
}
