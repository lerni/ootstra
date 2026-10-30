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

        $html = (string) parent::__invoke($entrypoints->all(), $buildDirectory);

        // Key per tag so shared chunks are deduplicated across differently grouped vite calls
        preg_match_all('#<script\b[^>]*>.*?</script>|<link\b[^>]*>#is', $html, $matches);
        foreach ($matches[0] as $tag) {
            Requirements::insertHeadTags($tag, 'vite:' . md5($tag));
        }

        // Return empty – assets are injected into <head> via Requirements
        return new HtmlString('');
    }
}
