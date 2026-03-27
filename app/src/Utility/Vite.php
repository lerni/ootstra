<?php

namespace App\Utility;

use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use SilverStripe\View\Requirements;
use Bigfork\Vitesse\Vite as VitesseVite;

class Vite extends VitesseVite
{
    public function __invoke($entrypoints, $buildDirectory = null)
    {
        $entrypoints = new Collection($entrypoints);

        // Use a stable key per unique set of entrypoints so Requirements deduplicates
        $key = 'vite:' . $entrypoints->sort()->implode(',');

        $html = (string) parent::__invoke($entrypoints->all(), $buildDirectory);

        if ($html) {
            Requirements::insertHeadTags($html, $key);
        }

        // Return empty – assets are injected into <head> via Requirements
        return new HtmlString('');
    }
}
