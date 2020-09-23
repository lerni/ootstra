<?php

namespace App\Model;

use Page;
use PageController;
use SilverStripe\Control\Controller;
use SilverStripe\Control\Director;
use SilverStripe\Forms\LiteralField;
use App\Controller\ElementPageController;

class ElementPage extends Page
{
    private static $has_one = [];

    private static $has_many = [];

    private static $owns = [];

    private static $table_name = 'ElementPage';

    private static $description = 'Allows modular content composition with elements.';

    public function CanonicalLink()
    {
        if (Controller::curr()->urlParams['Action'] == 'job') {
            $c = Controller::curr();
            $base = Director::absoluteBaseURL();
            $siteURL = $c->Link();
            $action = $c->urlParams['Action'];
            $id = $c->urlParams['ID'];
            return Controller::join_links(
                $base,
                $siteURL,
                $action,
                $id
            );
        }
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        if (!$this->hasHero()) {
            $message = _t('App\Model\ElementPage.HeroNeeded', 'Wenn kein "Hero" als oberstes Element vorhanden ist, wird <a href="/admin/settings/">default HeadeImage</a> verwendet.');
            $fields->unshift(
                LiteralField::create(
                    'HeroNeeded',
                    sprintf(
                        '<p class="alert alert-warning">%s</p>',
                        $message
                    )
                )
            );
        }

        return $fields;
    }

    public function hasHero()
    {
        if ($this->hasExtension('DNADesign\Elemental\Extensions\ElementalPageExtension')) {
            if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->First()->ClassName == 'App\Elements\ElementHero') {
                return true;
            }
            if ($this->ElementalArea()->Elements()->Count() && $this->ElementalArea()->Elements()->First()->ClassName == 'DNADesign\ElementalVirtual\Model\ElementVirtual') {
                if ($this->ElementalArea()->Elements()->First()->LinkedElement()->ClassName == 'App\Elements\ElementHero') {
                    return true;
                }
            }
        }
    }

    public function getControllerName()
    {
        return ElementPageController::class;
    }
}
