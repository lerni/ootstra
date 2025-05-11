<?php

namespace App\Controller;

use App\Models\Perso;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\Color\Color;
use SilverStripe\Control\Director;
use SilverStripe\Security\Security;
use Endroid\QrCode\Writer\SvgWriter;
use SilverStripe\Control\Controller;
use SilverStripe\Core\Config\Config;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\RoundBlockSizeMode;
use App\Controller\PersovCardController;
use Endroid\QrCode\ErrorCorrectionLevel;

class PersoQRController extends Controller
{

    private static $allowed_actions = [
        'index'
    ];

    public function index()
    {
        $expose_vcards = Config::inst()->get(PersovCardController::class, 'expose_vcards');
        (int)$ID = $this->getRequest()->param('ID');
        $perso = Perso::get()->byID($ID);


        if ((!Security::getCurrentUser() && !$expose_vcards) || !$perso) {
            return $this->httpError(403, 'You must be logged in to view this QR code');
        }

        $baseURL = Director::absoluteBaseURL();
        $qrURL = Controller::join_links(
            $baseURL,
            '_vc',
            $perso->ID,
        );

        $qrCode = new QrCode(
            data: $qrURL,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 0,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
            foregroundColor: new Color(0, 0, 0),
            backgroundColor: new Color(255, 255, 255, 0)
        );

        // Create generic logo
        // $logo = new Logo(
        //     path: '_resources/themes/default/dist/images/svg/logo.svg',
        //     resizeToWidth: 68,
        //     resizeToHeight: 68
        // );

        // Create SVG writer and generate QR code
        $writer = new SvgWriter();
        $result = $writer->write($qrCode);

        $this->getResponse()->addHeader('Content-Type', 'image/svg+xml');
        $this->getResponse()->addHeader('X-Robots-Tag', 'noindex');
        return $result->getString();
    }
}
