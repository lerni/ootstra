<?php

namespace App\Controller;

use App\Models\Perso;
use SilverStripe\i18n\i18n;
use App\Elements\ElementPerso;
use JeroenDesloovere\VCard\VCard;
use SilverStripe\Control\Director;
use App\Extensions\UrlifyExtension;
use SilverStripe\Control\Controller;
use SilverStripe\SiteConfig\SiteConfig;

class PersovCardController extends Controller
{

    public static $expose_vcards = false;

    private static $allowed_actions = [
        'index'
    ];

    public function index()
    {

        $ID = (int)$this->getRequest()->param('ID');
        $perso = Perso::get()->byID($ID);
        $expose_vcards = $this->config()->get('expose_vcards');
        if ((!$expose_vcards) || !$perso) {
            return $this->httpError(404, 'Perso not found');
        }

        $vcard = new VCard();
        $charset = 'utf-8';
        $vcard->setCharset($charset);

        $vcard->addName($perso->Lastname, $perso->AcademicTitle, $perso->Firstname);
        $vcard->addCompany(SiteConfig::current_site_config()->Title);
        $vcard->addJobtitle($perso->Position);
        $vcard->addEmail($perso->EMail);
        $vcard->addPhoneNumber($perso->Telephone, 'PREF;WORK');

        if ($location = SiteConfig::current_site_config()->Locations()->first()) {
            $countryCode = $location->Country;
            $AllCountries = i18n::getData()->getCountries();
            $country = $AllCountries[$countryCode];

            $vcard->addAddress(null, null, $location->Address, $location->Town, null, $location->PostalCode, $country);
            $vcard->addLabel("$location->Address, $location->Town, $location->PostalCode $country");
        }

        $element = ElementPerso::get()->filter(['Persos.ID' => $ID])->first();
        $link = null;

        // case $perso has Urlifyextension
        if ($perso->hasCustomMethod(UrlifyExtension::class)) {
            $link = Controller::join_links(
                Director::protocolAndHost(),
                $perso->AbsoluteLink()
            );
        // else use teampage
        } elseif($element &&
            $element->Parent() &&
            $element->Parent()->getOwnerPage()
            ) {
            $page_link = $element->Parent()->getOwnerPage()->Link();
            $link = Controller::join_links(
                Director::protocolAndHost(),
                $page_link
            );
        }
        // fallback to baseURL if no specific link found
        if (!$link) {
            $link = Controller::join_links(
                Director::protocolAndHost(),
                Director::baseURL()
            );
        }
        $vcard->addURL($link);

        // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
        $current = dirname(Director::baseFolder(), 2) . '/current';
        if (is_dir($current)) {
            $base = dirname(Director::baseFolder(), 2) . '/shared';
        } else {
            $base = Director::baseFolder();
        }

        if ($perso->Portrait() && $perso->Portrait()->exists()) {
            $original_filename_relative  = $perso->Portrait()->FocusFillMax(305,400)->Link();
            $original_filename_absolute  = $base . '/public' . $original_filename_relative;
            $vcard->addPhoto($original_filename_absolute);
        }

        $this->getResponse()->addHeader('Content-Type', 'text/x-vcard; charset=' . $charset);
        $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');

        // return vcard as a download
        // return vcard as a string
        // return $vcard->getOutput();
        return $vcard->download();

    }
}
