<?php

namespace App\Extensions;

use DNADesign\Elemental\Models\ElementalArea;
use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataExtension;

class ElementalPageExtension extends DataExtension
{
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
