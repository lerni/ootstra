<?php

namespace App\Controller;

use App\Models\Perso;
use SilverStripe\i18n\i18n;
use App\Elements\ElementPersoCFA;
use JeroenDesloovere\VCard\VCard;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
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

        (int)$ID = $this->getRequest()->param('ID');
        $perso = Perso::get()->byID($ID);
        $expose_vcards = $this->config()->get('expose_vcards');
        if ((!Security::getCurrentUser() && !$expose_vcards) || !$perso) {
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

        if ($location = SiteConfig::current_site_config()->Locations()->First()) {
            $countryCode = $location->Country;
            $AllCountries = i18n::getData()->getCountries();
            $country = $AllCountries[$countryCode];

            $vcard->addAddress(null, null, $location->Address, $location->Town, null, $location->PostalCode, $country);
            $vcard->addLabel("$location->Address, $location->Town, $location->PostalCode $country");
        }
        $element = ElementPersoCFA::get()->filter(['Persos.ID' => $ID])->first();
        if ($element) {
            $page_link = $element->Parent()->getOwnerPage()->Link();
            $vcard->addURL(Director::protocolAndHost() . $page_link);
        }

        // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
        $current = dirname(dirname(Director::baseFolder())) . '/current';
        if (is_dir($current)) {
            $base = dirname(dirname(Director::baseFolder())) . '/shared';
        } else {
            $base = Director::baseFolder();
        }

        if ($perso->Portrait() && $perso->Portrait()->exists()) {
            $original_filename_relative  = $perso->Portrait()->FocusFillMax(305,400)->Link();
            $original_filename_absolute  = $base . '/public' . $original_filename_relative;
            $vcard->addPhoto($original_filename_absolute);
        }

        $this->getResponse()->addHeader('Content-Type', "text/x-vcard; charset=$charset");
        $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');

        // return vcard as a download
        // return vcard as a string
        // return $vcard->getOutput();
        return $vcard->download();

    }
}
