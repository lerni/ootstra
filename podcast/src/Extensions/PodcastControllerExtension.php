<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use Kraftausdruck\Models\PodcastEpisode;

class PodcastControllerExtension extends Extension
{

    private static $allowed_actions = [
        'podcast'
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
}
