<?php

namespace App\Controller;

use App\Models\Point;
use SilverStripe\i18n\i18n;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\View\ArrayData;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Admin\LeftAndMain;
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

        // Only load frontend requirements if not in admin area
        if (!(Controller::curr() instanceof LeftAndMain)) {
            $locale = i18n::get_locale();
            $lang = i18n::convert_rfc1766($locale);
            $key = Environment::getEnv('APP_GOOGLE_MAPS_KEY') ?: Config::inst()->get(GoogleMapField::class, 'api_key');
            if ($key) {
                Requirements::javascript('https://maps.google.com/maps/api/js?language='. $lang .'&key='. $key . '&callback=init', [ 'defer' => true ]);
            } else {
                Requirements::javascript('https://maps.google.com/maps/api/js?language='. $lang . '&callback=init', [ 'defer' => true ]);
            }

            $defaultLat = 0.0;
            $defaultLng = 0.0;
            if ((float)$defaultLat == 0.0 && (float)$defaultLng == 0.0) {
                $yamlConfig = Config::inst()->get('BetterBrief\\GoogleMapField', 'default_field_values');
                if ($yamlConfig && isset($yamlConfig['Latitude'])) {
                    $defaultLat = (float)$yamlConfig['Latitude'];
                }
                if (isset($yamlConfig['Longitude'])) {
                    $defaultLng = (float)$yamlConfig['Longitude'];
                }
            }

            Requirements::javascriptTemplate("themes/default/src/js/include/google-map.js", [
                'Zoom' => $this->Zoom,
                'Scale' => $this->Scale,
                'Fullscreen' => $this->Fullscreen,
                'StreetView' => $this->StreetView,
                'ShowZoom' => $this->ShowZoom,
                'MapType' => $this->MapType,
                'ControllerLink' => $this->ControllerLink(),
                'Lat' => $defaultLat,
                'Lng' => $defaultLng
            ]);
        }
    }

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
                    'Type' => $item->Type
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
            return json_encode($r->toNestedArray());
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
