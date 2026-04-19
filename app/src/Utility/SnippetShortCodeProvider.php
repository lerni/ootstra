<?php

namespace App\Utility;

use App\Models\ShortCodeSnippet;

class SnippetShortCodeProvider
{
    public static function SnippetShortCodeProvider($arguments, $content = null, $parser = null, $titleName = null)
    {
        if (!ShortCodeSnippet::get()->count()) {
            return false;
        }

        if (!isset($arguments['title'])) {
            return '';
        }

        return ShortCodeSnippet::RenderCode($arguments) ?: '';
    }
}
