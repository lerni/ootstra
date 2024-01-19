<?php

namespace App\Extensions;

use SilverStripe\View\SSViewer;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\CheckboxField;
use DNADesign\Elemental\Models\ElementalArea;

class ElementalPageExtension extends Extension
{
    private static $db = [
        'PreventHero' => 'Boolean'
    ];

    public function updateCMSFields(FieldList $fields)
    {
        if (!$this->owner->hasHero()) {
            if (!$this->owner->PreventHero) {
                $message = _t('App\Models\ElementPage.HeroNeeded', 'If there is no "Hero" as top element, <a href="/admin/settings/">default Header Slides</a> are used.');
                $fields->fieldByName('Root.Main')->unshift(
                    LiteralField::create(
                        'HeroNeeded',
                        sprintf(
                            '<p class="alert alert-warning">%s</p>',
                            $message
                        )
                    )
                );
            }
            $fields->addFieldToTab('Root.Main', CheckboxField::create('PreventHero', _t('App\Models\ElementPage.PREVENTHERO', 'prevent default Header Slides')), 'ElementalArea');
        }
    }

    // this is a tewaked version of ElementalPageExtension::getElementsForSearch
    public function getElementsForSummary()
    {
        $oldThemes = SSViewer::get_themes();
        SSViewer::set_themes(SSViewer::config()->get('themes'));
        try {
            $output = [];
            foreach ($this->owner->hasOne() as $key => $class) {
                if ($class !== ElementalArea::class) {
                    continue;
                }
                /** @var ElementalArea $area */
                $area = $this->owner->$key();
                if ($area) {
                    $output[] = strip_tags($area->forTemplate());
                }
            }
        } finally {
            // Reset theme if an exception occurs, if you don't have a
            // try / finally around code that might throw an Exception,
            // CMS layout can break on the response. (SilverStripe 4.1.1)
            SSViewer::set_themes($oldThemes);
        }

        $output = implode($output);

        $output = preg_replace('/<[^>]*>/', ' ', $output);

        // ----- remove control characters -----
        $output = str_replace("\r", '', $output);    // --- replace with empty space
        $output = str_replace("\n", ' ', $output);   // --- replace with space
        $output = str_replace("\t", ' ', $output);   // --- replace with space

        // ----- remove multiple spaces -----
        $output = trim(preg_replace('/ {2,}/', ' ', $output));
        return html_entity_decode($output);
    }
}
