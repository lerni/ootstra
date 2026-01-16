<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\VendorPlugin\Util;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

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
        'sameAs' => true
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
            $iconURL = 'https://simpleicons.org/';
            $TitleField->setDescription(_t(__CLASS__ . '.IconNameDescription', 'Icon names from <a href="{link}" target="_blank">{link}</a>!', [ 'link' => $iconURL ]));
        }

        $valueArray = $this->getAvailableIconNames();

        $iconNameField = DropdownField::create(
            'IconName',
            _t(__CLASS__ . '.ICONNAME', 'Icon name'),
            $valueArray
        );
        $iconNameField->setDescription(_t(__CLASS__ . '.IconName', 'Icon names from <a href="{link}" target="_blank">{link}</a>!', [ 'link' => $iconURL ]));
        $fields->replaceField('IconName', $iconNameField);

        return $fields;
    }

    public function getAvailableIconNames() {
        $base = Director::baseFolder();
        $result = [];

        // Load simple-icons
        $simpleIconsPath = 'vendor/simple-icons/simple-icons/data/simple-icons.json';
        $fullPath = Util::joinPaths($base, $simpleIconsPath);
        if (file_exists($fullPath)) {
            $jsonString = file_get_contents($fullPath);
            $data = json_decode($jsonString, true);

            foreach($data as $item) {
                $titleSanitized = preg_replace( '/[^a-z0-9]+/', '', strtolower($item['title']) );
                $result[$titleSanitized] = $item['title'];
            }
        }

        // Load additional icons
        $additionalIconsPath = 'app/thirdparty/additional-icons/icons.json';
        $additionalFullPath = Util::joinPaths($base, $additionalIconsPath);
        if (file_exists($additionalFullPath)) {
            $additionalJsonString = file_get_contents($additionalFullPath);
            $additionalData = json_decode($additionalJsonString, true);

            foreach($additionalData as $item) {
                $titleSanitized = preg_replace( '/[^a-z0-9]+/', '', strtolower($item['title']) );
                $result['custom_' . $titleSanitized] = $item['title'] . ' (Custom)';
            }
        }

        return $result;
    }

    public function getIconPath() {
        $iconName = $this->IconName;

        // Check if it's a custom icon (prefixed with 'custom_')
        if (strpos($iconName, 'custom_') === 0) {
            $cleanIconName = str_replace('custom_', '', $iconName);
            return "/_resources/app/thirdparty/additional-icons/icons/{$cleanIconName}.svg";
        } else {
            // Default simple-icons path
            return "/_resources/vendor/simple-icons/simple-icons/icons/{$iconName}.svg";
        }
    }

    public function getCMSValidator()
    {
        return RequiredFieldsValidator::create([
            'Title',
            'IconName'
        ]);
    }
}
