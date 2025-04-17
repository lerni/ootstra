<?php

namespace App\Controller;

use App\Models\Point;
use SilverStripe\i18n\i18n;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use DNADesign\Elemental\Controllers\ElementController;

class ElementMapsController extends ElementController
{

    private static $allowed_actions = [
        'jpoints'
    ];

    public function init()
    {
        parent::init();

        $Lang = i18n::get_locale();
        $Lang = substr($Lang, 0, 2);
        $key = Environment::getEnv('APP_GOOGLE_MAPS_KEY') ?: Config::inst()->get(GoogleMapField::class, 'api_key');
        if ($key) {
            Requirements::javascript('https://maps.google.com/maps/api/js?language='. $Lang .'&key='. $key . '&callback=init', [ 'defer' => true ]);
        } else {
            Requirements::javascript('https://maps.google.com/maps/api/js?language='. $Lang . '&callback=init', [ 'defer' => true ]);
        }

        Requirements::javascriptTemplate("themes/default/src/js/include/google-map.js", [
            'Zoom' => $this->Zoom,
            'Scale' => $this->Scale,
            'Fullscreen' => $this->Fullscreen,
            'StreetView' => $this->StreetView,
            'MapType' => $this->MapType,
            'ControllerLink' => $this->ControllerLink()
        ]);
    }

    //public function jpoints(SS_HTTPRequest $r) {
    public function jpoints()
    {
        if (Director::is_ajax()) {

            $list = $this->element->Points();

            $r = ArrayList::create();
            foreach ($list as $item) {
                $d = ArrayData::create([
                    'Title' => $item->Title,
                    'Latitude' => $item->Latitude,
                    'Longitude' => $item->Longitude,
                    'PointURL' => $item->PointURL,
                    'Parking' => $item->Parking
                ]);
                if ($item->PointURL) {
                    $d->PointURL = $item->PointURL;
                } else {
                    $d->PointURL = $item->GMapLatLngLink();
                }

                $r->push($d);
            }

            $this->getResponse()->addHeader('Content-Type', 'application/json; charset=utf-8');
            $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');
            if ($list->count()) {
                return json_encode($r->toNestedArray());
            }
        }
        return false;
    }

    public function ControllerLink()
    {
        $url = Controller::join_links(
            Director::protocolAndHost(),
            $this->getPage()->RelativeLink(true),
            'element',
            $this->ID,
            'jpoints'
        );
        return $url;
    }
}
