<?php

namespace App;

use SilverStripe\i18n\i18n;
use SilverStripe\View\TemplateGlobalProvider;


class TemplateGlobals implements TemplateGlobalProvider
{
    public static function ContentLocaleShort()
    {
        $lang = explode('_', i18n::get_locale());
        return $lang[0];
    }

    public static function get_template_global_variables()
    {
        return [
            'ContentLocaleShort'
        ];
    }
}
