<?php

namespace App;

use SilverStripe\Core\Path;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\FieldType\DBHTMLText;
use SilverStripe\View\TemplateGlobalProvider;

class TemplateGlobals implements TemplateGlobalProvider
{
    /**
     * Short locale code (e.g. 'de' from 'de_CH')
     */
    public static function ContentLocaleShort()
    {
        return i18n::getData()->langFromLocale(i18n::get_locale());
    }

    /**
     * Inline SVG icon helper for templates.
     * Usage in .ss templates: $SvgIcon('mail'), $SvgIcon('phone'), $SvgIcon('shield-check')
     */
    public static function SvgIcon(string $name): ?DBHTMLText
    {
        $name = basename($name, '.svg');

        // 1. Project icons
        $projectPath = Path::join(BASE_PATH, 'themes', 'default', 'src', 'images', 'svg', $name . '.svg');
        if (is_file($projectPath)) {
            $svg = file_get_contents($projectPath);
            $svg = trim($svg);

            $field = DBHTMLText::create();
            $field->setValue($svg);

            return $field;
        }
    }

    public static function get_template_global_variables()
    {
        return [
            'ContentLocaleShort',
            'SvgIcon',
        ];
    }
}
