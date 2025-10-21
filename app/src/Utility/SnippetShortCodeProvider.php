<?php

namespace App\Utility;

use App\Models\ShortCodeSnippet;

class SnippetShortCodeProvider
{
    public static function SnippetShortCodeProvider($arguments, $content = null, $parser = null, $titleName = null)
    {
        if (ShortCodeSnippet::get()->count()) {

            $text = '';
            if (isset($arguments['title'])) {
                $title = $arguments['title'];
                $snippet = ShortCodeSnippet::get()->filter(['Title' => $title])->first();
                if ($snippet) {
                    $text = $snippet->RenderCode($arguments);
                }
            }

            return $text;
        }
        return false;
    }
}
