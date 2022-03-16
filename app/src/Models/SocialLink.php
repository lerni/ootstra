<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
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
        $labels['sameAs'] = _t(__CLASS__ . '.sameAs', '"sameAs" in schema verwenden');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if ($TitleField = $fields->dataFieldByName('Title')) {
            $feathericonURL = 'https://feathericons.com/';
            $TitleField->setDescription(_t(__CLASS__ . '.TitleDescription', 'Just use names from <a href="{link}" target="_blank">{link}</a>!', [ 'link' => $feathericonURL ]));
        }

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        if (!$this->Title) {
            $result->addError('Title ist zwingend erforderlich!');
        }

        return $result;
    }
}
