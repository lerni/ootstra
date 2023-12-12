<?php

namespace App\Controller;

use App\Models\Perso;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use SilverStripe\Assets\File;
use Endroid\QrCode\Color\Color;
use SilverStripe\i18n\i18n;
use JeroenDesloovere\VCard\VCard;
use SilverStripe\Control\Director;
use SilverStripe\i18n\Data\Locales;
use Endroid\QrCode\Writer\SvgWriter;
use SilverStripe\Control\Controller;
use Endroid\QrCode\Encoding\Encoding;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Parsers\URLSegmentFilter;
use SilverStripe\Core\Manifest\ModuleResourceLoader;
use DNADesign\Elemental\Controllers\ElementController;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;

class ElementPersoController extends ElementController
{

    public function Link($action = null)
    {
        $id = $this->element->ID;
        $segment = Controller::join_links('element', $id, $action);
        $page = Director::get_current_page();
        if ($page && !($page instanceof ElementController)) {
            return $page->Link($segment);
        }
        return $segment;
    }

    private static $allowed_actions = [
        'vcard'
    ];

    public function init()
    {
        parent::init();
    }

    public function vcard()
    {
        (int)$ID = $this->getRequest()->param('ID');
        $expose_vcards = $this->config()->get('expose_vcards');
        $perso = Perso::get()->byID($ID);

        if ($perso && $expose_vcards) {

            $vcard = new VCard();
            $charset = 'utf-8';
            $vcard->setCharset($charset);

            $vcard->addName($perso->Lastname, $perso->Firstname);
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
            $vcard->addURL(Director::protocolAndHost() . Director::get_current_page()->Link() . '#' . $perso->Anchor());

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

            // return vcard as a string
            // return $vcard->getOutput();

            $this->getResponse()->addHeader('Content-Type', "text/x-vcard; charset=$charset");
            $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');

            // return vcard as a download
            return $vcard->download();
        } else {
            return $this->owner->httpError(404, _t(__CLASS__ . '.NotFound', 'vCard couldn\'t be found.'));
        }
    }

    public function qrvc($ID)
    {

        $perso = Perso::get()->byID($ID);

        if ($perso->exists()) {
            // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
            $base = Director::baseFolder();
            $current = dirname(dirname($base)) . '/current';
            if (is_dir($current)) {
                $basePath = dirname(dirname($base)) . '/shared';
            } else {
                $basePath = $base;
            }

            $baseURL = Director::absoluteBaseURL();
            $qrURL = Controller::join_links(
                $baseURL,
                $this->Link(),
                'vcard',
                $perso->ID,
            );

            $filter = new URLSegmentFilter();
            $qrURLNomalized = $filter->filter($qrURL . $perso->LastEdited);

            $tmp_filename = sys_get_temp_dir() . '/' . $qrURLNomalized . '.svg';
            $relative_filepath = 'qr/' . $perso->ID . '.svg';
            $absolute_filepath = $basePath . '/public/assets/qr/' . $perso->ID . '.svg';

            // Check for existing cached thumbnail and date
            if (is_file($absolute_filepath)) {
                if (filemtime($absolute_filepath) < ((int)strtotime($perso->LastEdited) - 3)) {
                    // the file should be deleted
                    // unlink($absolute_filepath);
                    $obsoletRecord = File::get()->filter(['FileFilename' =>'qr/' . $perso->ID . '.svg'])->first();
                    $obsoletRecord->delete();
                    $obsoletRecord->revokeFile();
                    $obsoletRecord->deleteFile(true);
                } else {
                    $file = File::get()->filter(['FileFilename' => $relative_filepath])->first();
                }
            }

            if (!isset($file)) {
                // Create QR code
                $qrCode = QrCode::create($qrURL)
                    ->setEncoding(new Encoding('UTF-8'))
                    ->setErrorCorrectionLevel(new ErrorCorrectionLevelHigh())
                    ->setSize(300)
                    ->setMargin(0)
                    ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
                    ->setForegroundColor(new Color(42, 145, 208))
                    ->setBackgroundColor(new Color(255, 255, 255, 0));

                // Create generic logo
                // $logo = Logo::create(rtrim(Director::absoluteBaseURL(), '/') . ModuleResourceLoader::resourceURL('themes/default/dist/images/svg/scanme.svg'))
                // $logo = Logo::create('_resources/themes/default/dist/images/svg/scanme.svg')
                //     ->setResizeToWidth(68)
                //     ->setResizeToHeight(68);

                $writer = new SvgWriter();
                $result = $writer->write($qrCode);
                $result->saveToFile($tmp_filename);

                if (!file_exists($tmp_filename))
                    return false;

                $file = new File();
                $file->Title = $perso->getTitle();
                $file->setFromLocalFile($tmp_filename, 'qr/' . $perso->ID . '.svg');
                $file->write();
                $file->publishSingle();
            }

            return $file;
        }
    }
}
