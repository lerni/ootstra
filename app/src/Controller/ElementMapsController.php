<?php

namespace App\Controller;

use App\Models\Point;
use TractorCow\Fluent\Model\Locale;
use SilverStripe\i18n\i18n;
use BetterBrief\GoogleMapField;
use SilverStripe\ORM\ArrayList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\View\Requirements;
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

        if (class_exists('TractorCow\Fluent\Model\Locale')) {
            $Lang = Locale::getCurrentLocale();
        } else {
            $Lang = i18n::get_locale();
        }
        $Lang = substr($Lang, 0, 2);

        $gmapDefaultConfig = Config::inst()->get(GoogleMapField::class, 'default_options');
        if (isset($gmapDefaultConfig['api_key'])) {
            $key = $gmapDefaultConfig['api_key'];
            // Requirements::javascript('https://maps.google.com/maps/api/js?language='. $Lang .'&key='. $key, [ 'defer' => true, 'async' => true ]);
            Requirements::javascript('https://maps.google.com/maps/api/js?language=' . $Lang . '&key=' . $key);
        } else {
            Requirements::javascript('https://maps.google.com/maps/api/js?language=' . $Lang, ['defer' => true, 'async' => true]);
        }

        Requirements::javascriptTemplate("themes/default/src/js/include/google-map.js", array(
            'Zoom' => $this->Zoom,
            'Scale' => $this->Scale,
            'Fullscreen' => $this->Fullscreen,
            'StreetView' => $this->StreetView,
            'MapType' => $this->MapType,
            'ControllerLink' => $this->ControllerLink()
        ));
    }

    //public function jpoints(SS_HTTPRequest $r) {
    public function jpoints()
    {
        if (Director::is_ajax()) {

            $list = $this->element->Points();

            $r = ArrayList::create();
            foreach ($list as $item) {
                $d = DataObject::create();

                $d->Title = $item->Title;
                $d->Latitude = $item->Latitude;
                $d->Longitude = $item->Longitude;
                if ($item->PointURL) {
                    $d->PointURL = $item->PointURL;
                } else {
                    $d->PointURL = $item->GMapLatLngLink();
                }

                $r->push($d);
            }

            $this->getResponse()->addHeader("Content-Type", "application/json; charset=utf-8");
            if ($list->count()) {
                return json_encode($r->toNestedArray());
            }
        }
        return false;
    }

    public function ControllerLink()
    {
        return Director::protocolAndHost() . '/' . $this->getPage()->RelativeLink(true) . 'element/' . $this->ID . '/jpoints';
    }
}
