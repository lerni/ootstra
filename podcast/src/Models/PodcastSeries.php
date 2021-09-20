<?php

namespace Kraftausdruck\Models;


use App\Models\ElementPage;
use SilverStripe\Dev\Debug;
use SilverStripe\i18n\i18n;
use Spatie\SchemaOrg\Schema;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Control\Director;
use SilverStripe\Forms\EmailField;
use SilverStripe\Security\Security;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use Kraftausdruck\Elements\ElementPodcast;
use SilverStripe\Forms\GroupedDropdownField;

class PodcastSeries extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'OwnerName' => 'Varchar',
        'OwnerEmail' => 'Varchar',
        'Sort' => 'Int',
        'Description' => 'HTMLText',
        'Locale' => 'Varchar',
        'IsDefault' => 'Boolean',
        'CopyrightHolder' => 'Varchar',
        // todo: google & apple do not suggest the same thing - either way it doesn't validate ATM
            // https://validator.w3.org/feed/
            // https://validator.w3.org/feed/docs/error/InvalidItunesCategory.html
            // https://support.google.com/podcast-publishers/answer/9889544?hl=en#podcast_tags&zippy=%2Cempfohlene-kategorien%2Crecommended-categories
        // 'Category' => "Enum('Arts,Business,Comedy,Education,Games &amp; Hobbies,Government &amp; Organizations,Health,Kids &amp; Family,Music,News &amp; Politics,Religion &amp; Spirituality,Science &amp; Medicine,Society &amp; Culture,Sports &amp; Recreation,TV &amp; Film,Technologie')"
        'Category' => 'Varchar'
    ];

    private static $has_one = [
        'Image' => Image::class
    ];

    private static $has_many = [
        'Episodes' => PodcastEpisode::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $table_name = 'PodcastSeries';

    private static $singular_name = 'Serie';
    private static $plural_name = 'Series';

    private static $default_sort = 'Sort ASC';

    public function populateDefaults()
    {
        parent::populateDefaults();

        $this->Title = _t(__CLASS__ . '.DefaultTitle', 'New series');

    }

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Thumbnail',
        'Title'
    ];

    private static $searchable_fields = [
        'Title'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Description'] = _t(__CLASS__ . '.DESCRIPTION', 'Description');
        $labels['IsDefault'] = _t(__CLASS__ . '.ISDEFAULT', 'default "PodcastSerie"');
        $labels['Locale'] = _t(__CLASS__ . '.LOCALE', 'default "Locale"');
        $labels['OwnerName'] = _t(__CLASS__ . '.OWNERNAME', 'Name owner');
        $labels['OwnerEmail'] = _t(__CLASS__ . '.OWNEREMAIL', 'E-Mail owner');
        $labels['Category'] = _t(__CLASS__ . '.CATEGORY', 'Category');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'Sort',
            'Episodes'
        ]);

        if ($TextEditorField = $fields->dataFieldByName('Description')) {
            $TextEditorField->setRows(20);
            $TextEditorField->addExtraClass('stacked');
        }

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('series');
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'Series Image - min. 1200x630px - if "Is default", this \'ll be used as default "Image" on creating new "Podcast-Episodes"'));
        }

        if ($fields->dataFieldByName('Category')) {
            $sourceFromConfig = $this->config()->get('categories');
            $i = 0;
            $subcategoryArray = [];
            foreach ($sourceFromConfig as $item) {
                if(is_array($item)) {
                    $keys = array_keys($item);
                    $key = $keys[0];
                    $ii = 0;
                    foreach($item as $subitem) {
                        $values[$subitem[$ii]] = $subitem[$ii];
                        $ii++;
                    }
                    // $subcategoryArray[$key] = $item[$key];
                    $subcategoryArray[$key] = $values;
                } else {
                    $subcategoryArray[$item] = $item;
                }
                $i++;
            }
            $CategoryField = GroupedDropdownField::create('Category');
            $CategoryField->setSource($subcategoryArray);
            $CategoryField->setEmptyString(_t(__CLASS__ . '.EmptyCategoryString', '--'));
            $CategoryField->setHasEmptyDefault(true);
            $fields->replaceField('Category', $CategoryField);
        }

        if ($ownerNameField = $fields->dataFieldByName('OwnerName')) {
            $ownerNameField->setTitle(_t(__CLASS__ . '.OWNERNAME', 'E-Mail owner'));
            $ownerNameField->setDescription(_t(__CLASS__ . '.OwnerDescription', 'iTunes & Google Podcast urge you to provide "{fieldName}"!', ['fieldName' => _t(__CLASS__ . '.OWNERNAME', 'Name owner')]));
        }

        if ($fields->dataFieldByName('OwnerEmail')) {
            $OwnerEmailField = EmailField::create('OwnerEmail');
            $fields->replaceField('OwnerEmail', $OwnerEmailField);
            $OwnerEmailField->setTitle(_t(__CLASS__ . '.OWNEREMAIL', 'E-Mail owner'));
            $OwnerEmailField->setDescription(_t(__CLASS__ . '.OwnerDescription', 'iTunes & Google Podcast urge you to provide "{fieldName}"!', ['fieldName' => _t(__CLASS__ . '.OWNEREMAIL', 'E-Mail owner')]));
        }

        if ($IsDefaultField = $fields->dataFieldByName('IsDefault')) {
            $IsDefaultField->setDescription(_t(__CLASS__ . '.IsDefaultDescription', 'Is uses as default "PodcastSeries" for new "Podcast-Episodes" - only one should be selected!'));
        }

        if ($fields->dataFieldByName('Locale')) {
            $allLocales = i18n::getSources()->getKnownLocales();
            $additionalLocales = Config::inst()->get('Kraftausdruck\Models\PodcastEpisode', 'additional_locales');
            foreach($additionalLocales as $al) {
                $allLocales = array_merge($allLocales, $al);
            }
            ksort($allLocales);

            $LocaleField = DropdownField::create(
                'Locale',
                _t(__CLASS__ . '.LOCALE', 'Locale', 'Locale for the Episode'),
                $allLocales
            );
            $LocaleField->setEmptyString(_t(__CLASS__ . '.EmptyLocaleString', '--'));
            $LocaleField->setHasEmptyDefault(true);
            $LocaleField->setDescription(_t(__CLASS__ . '.LocaleDescription', 'If "Is dafault", this \'ll be used as default "Locale" for new "Podcast-Episodes"'));
            $fields->replaceField('Locale', $LocaleField);
        }

        return $fields;
    }

    public function PodcastSeriesSchema()
    {
        $schema = Schema::PodcastSeries()
            ->description($this->Description)
            ->name($this->Title)
            ->url($this->AbsoluteLink())
            ->webFeed($this->AbsoluteLink(). 'rss');

            if ($this->Image()->exists()) {
                $schema->image(rtrim(Director::absoluteBaseURL(), '/') . $this->Image()->FocusFillMax('1200', '542')->Link());
            }

        $schema->setProperty('@id', $this->AbsoluteLink());

        return $schema->toScript();
    }

    public function AbsoluteLink()
    {
        $element = ElementPodcast::get()->filter(['PodcastSeriesID' => $this->ID])->first();
        if ($element) {
            return strtok($element->getPage()->AbsoluteLink(), '?');
        }
    }


    public function canView($member = null)
    {
        return true;
    }

    public function Locale639() {
        // pseudo ISO to for validation
        return str_replace('_','-',strtolower($this->Locale));
    }
}
