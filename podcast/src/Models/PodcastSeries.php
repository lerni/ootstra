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
use SilverStripe\Security\Security;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\DropdownField;
use Kraftausdruck\Elements\ElementPodcast;


class PodcastSeries extends DataObject
{
    private static $db = [
        'Title' => 'Varchar',
        'Sort' => 'Int',
        'About' => 'HTMLText',
        'Locale' => 'Varchar',
        'IsDefault' => 'Boolean',
        'CopyrightHolder' => 'Varchar'
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

        $labels['About'] = _t(__CLASS__ . '.ABOUT', 'About');
        $labels['IsDefault'] = _t(__CLASS__ . '.ISDEFAULT', 'default "PodcastSerie"');
        $labels['Locale'] = _t(__CLASS__ . '.LOCALE', 'default "Locale"');

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
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'Series Image - min. 1200x630px'));
        }

        if ($IsDefaultField = $fields->dataFieldByName('IsDefault')) {
            $IsDefaultField->setDescription(_t(__CLASS__ . '.IsDefaultDescription', 'Is uses as default "PodcastSerie" for new "PodcastEpisodes" - only one should be selected!'));
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
            $LocaleField->setDescription(_t(__CLASS__ . '.LocaleDescription', 'Is uses as default "Locale" for new "PodcastEpisodes"'));
            $fields->replaceField('Locale', $LocaleField);
        }

        return $fields;
    }

    public function PodcastSeriesSchema()
    {
        $schema = Schema::PodcastSeries()
            ->about($this->About)
            ->name($this->Title)
            ->image(rtrim(Director::absoluteBaseURL(), '/') . $this->Image()->FocusFillMax('1200', '542')->Link())
           ->url($this->AbsoluteLink())
            ->webFeed($this->AbsoluteLink(). 'rss');

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
}
