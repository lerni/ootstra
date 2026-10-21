<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Model\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\VendorPlugin\Util;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\Validation\CompositeValidator;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldDataColumns;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

class SocialLink extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'IconName' => 'Varchar',
        'Url' => 'Varchar',
        // 'Icon' => 'Enum("f,d,e,i,h,n,k,x,r,t,o,y,q,p,m,l,s")',
        'sameAs' => 'Boolean',
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

    private static $belongs_many_many = [
        'Persos' => Perso::class . '.SocialLinks',
        'SiteConfigs' => SiteConfig::class . '.SocialLinks',
    ];

    private static $table_name = 'SocialLink';

    private static $singular_name = 'Social-Link';

    private static $plural_name = 'Social-Links';

    private static $summary_fields = [
        'Title' => 'Titel',
        'Url' => 'Url',
    ];

    private static $searchable_fields = [
        'Title',
    ];

    private static $translate = [
        'Url',
    ];

    private static $defaults = [
        'sameAs' => true,
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['IconName'] = _t(self::class . '.ICONNAME', 'Icon name');
        $labels['sameAs'] = _t(self::class . '.SAMEAS', '"sameAs" use in schema');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Persos',
            'SiteConfigs',
        ]);

        $iconURL = 'https://simpleicons.org/';
        $valueArray = $this->getAvailableIconNames();

        $iconNameField = DropdownField::create(
            'IconName',
            _t(self::class . '.ICONNAME', 'Icon name'),
            $valueArray,
        );
        $iconNameField->setDescription(_t(self::class . '.IconNameDescription', 'Icon names from <a href="{link}" target="_blank">{link}</a>!', ['link' => $iconURL]));
        $fields->replaceField('IconName', $iconNameField);

        if ($this->isInDB()) {
            $usedBy = ArrayList::create();
            foreach ($this->SiteConfigs() as $siteConfig) {
                $usedBy->push(ArrayData::create([
                    'Type' => $siteConfig->i18n_singular_name(),
                    'Title' => $siteConfig->Title,
                ]));
            }
            foreach ($this->Persos() as $perso) {
                $usedBy->push(ArrayData::create([
                    'Type' => $perso->i18n_singular_name(),
                    'Title' => $perso->getTitle(),
                ]));
            }

            if ($usedBy->count() > 1) {
                $usedConfig = GridFieldConfig_Base::create(20);
                $usedConfig->removeComponentsByType([
                    GridFieldFilterHeader::class,
                    GridFieldSortableHeader::class,
                ]);
                $usedConfig->getComponentByType(GridFieldDataColumns::class)
                    ->setDisplayFields([
                        'Type' => _t(self::class . '.UsedByType', 'Type'),
                        'Title' => _t(self::class . '.TITLE', 'Title'),
                    ]);
                $usedGridField = GridField::create(
                    'SocialLinkUsedOn',
                    _t(self::class . '.IsUsedOnComment', '"{name}" is associated on', ['name' => $this->Title]),
                    $usedBy,
                    $usedConfig,
                );
                $fields->addFieldToTab('Root.Main', $usedGridField);
            }
        }

        return $fields;
    }

    public function getAvailableIconNames()
    {
        $base = Director::baseFolder();
        $result = [];

        // Load simple-icons
        $simpleIconsPath = 'vendor/simple-icons/simple-icons/data/simple-icons.json';
        $fullPath = Util::joinPaths($base, $simpleIconsPath);
        if (file_exists($fullPath)) {
            $jsonString = file_get_contents($fullPath);
            $data = json_decode($jsonString, true);

            foreach ($data as $item) {
                $titleSanitized = preg_replace('/[^a-z0-9]+/', '', strtolower($item['title']));
                $result[$titleSanitized] = $item['title'];
            }
        }

        // Load additional icons
        $additionalIconsPath = 'app/thirdparty/additional-icons/icons.json';
        $additionalFullPath = Util::joinPaths($base, $additionalIconsPath);
        if (file_exists($additionalFullPath)) {
            $additionalJsonString = file_get_contents($additionalFullPath);
            $additionalData = json_decode($additionalJsonString, true);

            foreach ($additionalData as $item) {
                $titleSanitized = preg_replace('/[^a-z0-9]+/', '', strtolower($item['title']));
                $result['custom_' . $titleSanitized] = $item['title'] . ' (Custom)';
            }
        }

        return $result;
    }

    public function getIconPath()
    {
        $iconName = $this->IconName;

        // Check if it's a custom icon (prefixed with 'custom_')
        if (str_starts_with($iconName, 'custom_')) {
            $cleanIconName = str_replace('custom_', '', $iconName);

            return "/_resources/app/thirdparty/additional-icons/icons/{$cleanIconName}.svg";
        }

        // Default simple-icons path
        return "/_resources/vendor/simple-icons/simple-icons/icons/{$iconName}.svg";
    }

    public function canDelete($member = null)
    {
        if (($this->Persos()->count() + $this->SiteConfigs()->count()) > 1) {
            return false;
        }

        return parent::canDelete($member);
    }

    public function getCMSCompositeValidator(): CompositeValidator
    {
        $validator = parent::getCMSCompositeValidator();
        $validator->addValidator(
            RequiredFieldsValidator::create([
                'Title',
                'IconName',
            ]),
        );

        return $validator;
    }
}
