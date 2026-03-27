<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;

class ElementalPageExtension extends Extension
{
    private static $db = [
        'PreventHero' => 'Boolean',
    ];

    public function updateCMSFields(FieldList $fields)
    {
        if (!$this->getOwner()->hasHero()) {
            if (!$this->getOwner()->PreventHero) {
                $message = _t('App\Models\ElementPage.HeroNeeded', 'If there is no "Hero" as top element, <a href="/admin/settings/">default Header Slides</a> are used.');
                $fields->fieldByName('Root.Main')->unshift(
                    LiteralField::create(
                        'HeroNeeded',
                        sprintf(
                            '<p class="alert alert-warning">%s</p>',
                            $message,
                        ),
                    ),
                );
            }
            $fields->addFieldToTab('Root.Main', CheckboxField::create('PreventHero', _t('App\Models\ElementPage.PREVENTHERO', 'Do not show default Hero-Slides')), 'ElementalArea');
        }
    }
}
