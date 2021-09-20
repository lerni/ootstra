<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Control\Controller;
use SilverStripe\Control\RSS\RSSFeed;
use SilverStripe\SiteConfig\SiteConfig;
use Kraftausdruck\Models\PodcastEpisode;
use Kraftausdruck\Elements\ElementPodcast;

class PodcastControllerExtension extends Extension
{

    // Provides a link to the Podcast RSS in the HTML head
    public function onAfterInit() {
        $podcastElement = $this->owner->ElementalArea()->Elements()->filter(['ClassName' => ElementPodcast::class])->first();
        if ($podcastElement) {
            $series = $podcastElement->PodcastSeries();
            RSSFeed::linkToFeed($this->AbsoluteBaseURLTrimmed() . $this->owner->Link('rss', true), $series->Title);
        }
    }

    private static $allowed_actions = [
        'podcast',
        'rss'
    ];

    public function podcast()
    {
        $URLSegment = $this->owner->getRequest()->param('ID');
        $URLAction = $this->owner->getRequest()->param('Action');
        $episode = PodcastEpisode::get()->filter('URLSegment', $URLSegment)->first();

        if ($episode && $episode->Active == 1) {

            $r['Item'] = $episode;

            if($episode->MetaTitle) {
                $r['MetaTitle'] = $episode->MetaTitle;
            } else {
                $r['MetaTitle'] = $episode->DefaultMetaTitle();
            }

            if($episode->MetaDescription) {
                $r['MetaDescription'] = $episode->MetaDescription;
            } else {
                $r['MetaDescription'] = $episode->DefaultMetaDescription();
            }

            $siteConfig = SiteConfig::current_site_config();
            if ($siteConfig->CanonicalDomain) {
                $base = trim($siteConfig->CanonicalDomain, '/');
            } else {
                $base = Director::absoluteBaseURL();
            }
            $canonicalLink = Controller::join_links(
                $base,
                $this->owner->Link(),
                $URLAction,
                $URLSegment
            );
            $r['CanonicalURL'] = $canonicalLink;

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

            return $r;
        } else {
            return [];
        }
    }

    public function AbsoluteBaseURLTrimmed() {
        return rtrim(Director::AbsoluteBaseURL(), '/');
    }
}
