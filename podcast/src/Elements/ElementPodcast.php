<?php

namespace Kraftausdruck\Elements;

use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use Kraftausdruck\Models\PodcastSeries;
use Kraftausdruck\Models\PodcastEpisode;
use DNADesign\Elemental\Models\BaseElement;

class ElementPodcast extends BaseElement
{

    private static $db = [
        'Primary' => 'Boolean',
        'NoPodcasts' => 'HTMLText'
    ];

    private static $has_one = [
        'PodcastSeries' => PodcastSeries::class
    ];

    private static $defaults = [
        'AvailableGlobally' => 0
    ];

    private static $table_name = 'ElementPodcast';

    private static $title = 'Podcast Element';

    private static $inline_editable = false;

    private static $icon = 'font-icon-block-podcast';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'AvailableGlobally',
            'PodcastSeries'
        ]);

        if ($AvailableGloballyField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableGloballyField->setDisabled(true);
        }

        if ($PrimaryField = $fields->dataFieldByName('Primary')) {
            if (!$this->Primary && $this->ClassName::get()->filter(['Primary' => 1])->count()) {
                $PrimaryPodcastElement = $this->ClassName::get()->filter(['Primary' => 1])->first()->AbsoluteLink();
                $PrimaryField = LiteralField::create(
                    'PrimaryIs',
                    sprintf(
                        '<p class="alert alert-info">Primary Podcast Element is %s</p>',
                        $PrimaryPodcastElement
                    )
                );
            }
            $fields->addFieldToTab('Root.Settings', $PrimaryField);
            $PrimaryField->setTitle(_t(__CLASS__ . '.PRIMARY', 'false'));
        }

        if ($PodcastSeriesField = $fields->dataFieldByName('PodcastSeriesID')) {
            // todo: somehow Dropdownfield it doesn't behave if selected item isn't in $source
            // we allow PodcastSeries to be linked just once, to maintain single URL
            $selected = $this->PodcastSeriesID;
            $excludedCosChoosen = array_unique($this->ClassName::get()->Column('PodcastSeriesID'));
            unset($excludedCosChoosen[array_search($this->PodcastSeriesID, $excludedCosChoosen)]);
            $source = PodcastSeries::get();
            if(count($excludedCosChoosen)) {
                $source =   $source->exclude(['ID' => $excludedCosChoosen]);            // ->map('Title', 'ID')
            }

            $PodcastSeriesField = DropdownField::create('PodcastSeriesID', _t(__CLASS__ . '.PODCASTSERIES', 'Podcast Series'), $source);
            $PodcastSeriesField->setEmptyString(_t(__CLASS__ . '.EmptyPodcastSeriesString', '--'));
            // $PodcastSeriesField->setHasEmptyDefault(true);
            $PodcastSeriesField->setDescription(_t(__CLASS__ . '.PodcastSeriesDescription', 'Podcast series should be linked only once!'));
            $fields->replaceField('PodcastSeriesID', $PodcastSeriesField);
        }

        if ($TextEditor = $fields->dataFieldByName('NoPodcasts')) {
            $TextEditor->setRows(10);
            $TextEditor->addExtraClass('stacked');
        }
        $message = _t(__CLASS__ . '.EditPodcastEpisodeHint', '<a href="/admin/podcasts">Create & edit</a> podcasts.');
        $fields->unshift(
            LiteralField::create(
                'EditPodcast',
                sprintf(
                    '<p class="alert alert-info">%s</p>',
                    $message
                )
            )
        );

        return $fields;
    }

    public function getItems()
    {

        $podcasts = PodcastEpisode::get()->filter(['Active' => 1, 'PodcastSeriesID' => $this->PodcastSeriesID])->filterByCallback(function ($record) {
            return $record->canView();
        });

        return $podcasts;
    }

    // first one should be primary unless selected differently
    public function populateDefaults()
    {
        $this->NoPodcasts = '<p>' . _t(__CLASS__ . '.DEFAULTNoPodcasts', 'Thank you very much for your interest. There are currently no podcasts available.') . '</p>';
        $this->Primary = 1;
        if ($podcastElements = $this->ClassName::get()->filter('Primary', 1)->count()) {
            $this->Primary = 0;
        }
        parent::populateDefaults();
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Podcast Element');
    }
}
