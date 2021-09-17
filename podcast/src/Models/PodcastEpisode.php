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
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Forms\ListboxField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\TextareaField;
use SilverStripe\Versioned\Versioned;
use Kraftausdruck\Models\PodcastSeries;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\CMS\Forms\SiteTreeURLSegmentField;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

class PodcastEpisode extends DataObject
{
    private static $db = [
        'Subtitle' => 'Varchar',
        'Active' => 'Boolean',
        'Locale' => 'Varchar',
        'MetaDescription' => 'Text',
        'Author' => 'Text',
        'Description' => 'HTMLText',
        'DatePosted' => 'Datetime',
        'Explicit' => 'Enum("No, Clean, Yes", "No")',
        'Duration' => 'Time'
    ];

    private static $has_one = [
        'Image' => Image::class,
        'Media' => File::class,
        'PodcastSeries' => PodcastSeries::class
    ];

    private static $owns = [
        'Image',
        'Media'
    ];

    private static $table_name = 'PodcastEpisode';

    private static $singular_name = 'Episode';
    private static $plural_name = 'Episodes';

    private static $default_sort = 'Sort ASC';

    public function populateDefaults()
    {
        parent::populateDefaults();

        $this->Title = _t(__CLASS__ . '.DefaultTitle', 'New episode');
        $this->DatePosted = DBDatetime::now()->value;

        $defautlPodcastSeries = PodcastSeries::get()->filter(['IsDefault' => 1])->first();
        if ($defautlPodcastSeries) {
            $this->Locale = $defautlPodcastSeries->Locale;
            $this->PodcastSeriesID = $defautlPodcastSeries->ID;
            $this->ImageID = $defautlPodcastSeries->ImageID;
        }
    }

    private static $defaults = [
        'Active' => 1
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Thumbnail',
        'Title',
        'PodcastSeries.Title',
        'Active'
    ];

    private static $searchable_fields = [
        'Title',
        'Active',
        'Author',
        'Explicit',
        'PodcastSeries.Title'
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);

        $labels['Subtitle'] = _t(__CLASS__ . '.SUBTITLE', 'Subtitle');
        $labels['Active'] = _t(__CLASS__ . '.ACTIVE', 'Active / published');
        $labels['Description'] = _t(__CLASS__ . '.DESCRIPTION', 'Description');
        $labels['DatePosted'] = _t(__CLASS__ . '.DATEPOSTED', 'Release date');
        $labels['Author'] = _t(__CLASS__ . '.AUTHOR', 'Author(s)');

        return $labels;
    }

    public function getCMSFields()
    {

        $fields = parent::getCMSFields();

        if ($ActiveField = $fields->dataFieldByName('Active')) {
            $ActiveField->setDescription(_t(__CLASS__ . '.ActiveDescription', 'Disabling prevents episode from appearing in iTunes/Google/Spotify and also in Live-Mode on the Website.<br/><strong>Still shows-up in Draft-Mode!</strong>'));
            $fields->insertBefore('Title', $ActiveField, true);
        }

        if ($SubtitleField = $fields->dataFieldByName('Subtitle')) {
            $fields->insertAfter('Title', $SubtitleField, true);
        }

        if ($DatePostedField = $fields->dataFieldByName('DatePosted')) {
            $DatePostedField->setDescription('');
            $DatePostedField->setAttribute('placeholder', 'Beispiel: 16.09.2021 20:12'); // todo translate
        }

        if ($DurationField = $fields->dataFieldByName('Duration')) {
            $DurationField->setHTML5(false);
            $DurationField->setTimeFormat('HH:mm:ss');
        }

        $allLocales = i18n::getSources()->getKnownLocales();
        $additionalLocales = $this->config()->additional_locales;
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
        $fields->replaceField('Locale', $LocaleField);

        if ($TextEditorField = $fields->dataFieldByName('Description')) {
            $TextEditorField->setRows(30);
            $TextEditorField->addExtraClass('stacked');
        }

        if ($uploadField = $fields->dataFieldByName('Image')) {
            $uploadField->setFolderName('episodes');
            $uploadField->setDescription(_t(__CLASS__ . '.ImageDescription', 'Episode Image - min. 1200x630px'));
        }

        if ($MediaUploadField = $fields->dataFieldByName('Media')) {
            $MediaUploadField->allowedExtensions = array('mp3', 'ogg', 'aac', 'm4a', 'flac');
            $MediaUploadField->setFolderName('episodes');
            $MediaUploadField->setDescription(_t(__CLASS__ . 'Media.MediaDesc', 'mp3 / ogg / aac/m4a / flac'));
        }

        if ($ExplicitField = $fields->dataFieldByName('Explicit')) {
            $ExplicitField->setDescription(_t(__CLASS__ . '.ExplicitDescription', 'Displays an "Explicit", "Clean" or no parental advisory graphic next to your episode in iTunes.'));
        }

        if ($AuthorField = $fields->dataFieldByName('Author')) {
            $AuthorField->setDescription(_t(__CLASS__ . '.AuthorDescription', 'New line each!'));
        }

        return $fields;
    }

    public function validate()
    {
        $result = parent::validate();

        // if(!$this->URLSegment) {
        //     $result->addError('URL-Segment wird benötigt');
        // }

        return $result;
    }

    public function PodcastEpisodeSchema()
    {
        $schema = Schema::PodcastEpisode()
            ->title($this->Title)
            ->description($this->Description)
            ->url($this->AbsoluteLink())
            ->datePosted($this->DatePosted);
            if ($this->Author) {
                // remove empty newlines
                $authorsString = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->Author);
                $authorLines = explode(PHP_EOL, $authorsString);
                $authors = [];
                $i = 0;
                foreach ($authorLines as $author) {
                    $authors[$i] = Schema::Person()
                    ->name($author);
                    $i++;
                }
                $schema->author($authors);
            }

        $schema->setProperty('@id', $this->AbsoluteLink());

        return $schema->toScript();
    }


    public function canView($member = null)
    {
        if ($member = Security::getCurrentUser()) {
            return true;
        } else {
            if (!$this->Active) {
                return false;
            }
            return true;
        }
    }

    public function link()
    {
        return $this->AbsoluteLink();
    }
}
