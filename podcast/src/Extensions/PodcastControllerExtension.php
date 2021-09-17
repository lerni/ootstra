<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Control\RSS\RSSFeed;
use Kraftausdruck\Models\PodcastEpisode;
use Kraftausdruck\Elements\ElementPodcast;

class PodcastControllerExtension extends Extension
{

    // Provides a link to the Podcast RSS in the HTML head
    public function onAfterInit() {
        $podcastElement = $this->owner->ElementalArea()->Elements()->filter(['ClassName' => ElementPodcast::class])->first();
        if ($podcastElement) {
            $series = $podcastElement->PodcastSeries();
            RSSFeed::linkToFeed($this->owner->Link('rss', true), $series->Title);
        }
    }

    private static $allowed_actions = [
        'podcast',
        'rss'
    ];

    public function podcast()
    {
        $URLSegment = $this->owner->getRequest()->param('ID');
        $episode = PodcastEpisode::get()->filter('URLSegment', $URLSegment)->first();

        if ($episode && $episode->Active == 1) {

            $r['Episode'] = $episode;

            if($episode->MetaTitle) {
                $r['MetaTitle'] = $episode->MetaTitle;
            } else {
                $r['MetaTitle'] = $episode->DefaultMetaTitle();
            }
            // todo: add Default...()
            if($episode->MetaDescription) {
                $r['MetaDescription'] = $episode->MetaDescription;
            }

            return $r;
        } else {
            return $this->owner->httpError(404, _t(__CLASS__ . '.NotFound', 'false'));
        }
    }

    public function rss()
    {
        $podcastElement = $this->owner->ElementalArea()->Elements()->filter(['ClassName' => ElementPodcast::class])->first();
        if ($podcastElement) {
            $series = $podcastElement->PodcastSeries();
            $episodes = $podcastElement->getItems();
            $r['Episodes'] = $episodes;
            $r['Series'] = $series;
            $this->owner->response->addHeader('Content-Type', 'application/xml');


            // return $this->owner->renderWith($this->owner->ClassName . '_rss');
            return $r;
        } else {
            return [];
        }
    }

    public function AbsoluteBaseURLTrimmed() {
        return rtrim(Director::AbsoluteBaseURL(), '/');
    }
}
