<?php

namespace Kraftausdruck\Elements;

use Kraftausdruck\Models\PodcastEpisode;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;

class ElementPodcast extends BaseElement
{

    private static $db = [
        'Primary' => 'Boolean',
        'NoPodcasts' => 'HTMLText'
    ];

    private static $defaults = [
        'AvailableGlobally' => 0
    ];

    private static $table_name = 'ElementPodcast';

    private static $title = 'Podcast Element';

    private static $inline_editable = false;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'isFullWidth',
            'AvailableGlobally'
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

        $jobs = PodcastEpisode::get()->filter(['Active' => 1])->filterByCallback(function ($record) {
            return $record->canView();
        });

        return $jobs;
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
