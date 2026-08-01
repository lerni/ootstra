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
     * Usage in .ss templates: $SvgIcon('arrow'), $SvgIcon('arrow', 'icon--sm icon--primary')
     *
     * Lookup order:
     *   1. themes/default/dist/assets/    - Vite-optimized, resolved via manifest (production)
     *   2. themes/default/src/images/svg/ - fallback for dev/watch mode (no manifest)
     *
     * Extra classes are injected into the root <svg> element at render time (after cache lookup,
     * so the same icon can be reused with different classes across call sites).
     */
    public static function SvgIcon(string $name, string $classes = ''): ?DBHTMLText
    {
        $name = basename($name, '.svg');

        if (isset(self::$svgCache[$name])) {
            $content = self::$svgCache[$name];
        } else {
            $content = null;

            // Prefer Vite-optimized version from dist via manifest
            $manifest = self::loadViteManifest();
            $manifestKey = 'src/images/svg/' . $name . '.svg';
            if ($manifest !== null && isset($manifest[$manifestKey]['file'])) {
                $distPath = Path::join(BASE_PATH, 'themes', 'default', 'dist', $manifest[$manifestKey]['file']);
                if (is_file($distPath)) {
                    $content = trim(file_get_contents($distPath));
                }
            }

            // Fallback to unoptimized source (dev/watch mode)
            if ($content === null) {
                $srcPath = Path::join(BASE_PATH, 'themes', 'default', 'src', 'images', 'svg', $name . '.svg');
                if (is_file($srcPath)) {
                    $content = trim(file_get_contents($srcPath));
                }
            }

            if ($content === null) {
                return null;
            }

            self::$svgCache[$name] = $content;
        }

        // Inject extra classes into the root <svg> element (not cached — varies per call site)
        if ($classes !== '') {
            $escaped = htmlspecialchars($classes, ENT_QUOTES);
            if (preg_match('/<svg\b[^>]*\bclass="/i', $content)) {
                // Merge with existing class attribute
                $content = preg_replace('/(<svg\b[^>]*\bclass=")/', '$1' . $escaped . ' ', $content, 1);
            } else {
                // No class attribute yet — add one
                $content = preg_replace('/<svg\b/i', '<svg class="' . $escaped . '"', $content, 1);
            }
        }

        $field = DBHTMLText::create();
        $field->setValue($content);

        return $field;
    }

    /** @var array<string, string> Per-request cache of resolved SVG content keyed by icon name */
    private static array $svgCache = [];

    private static ?array $viteManifest = null;

    private static bool $viteManifestLoaded = false;

    private static function loadViteManifest(): ?array
    {
        if (!self::$viteManifestLoaded) {
            self::$viteManifestLoaded = true;
            $manifestPath = Path::join(BASE_PATH, 'themes', 'default', 'dist', 'manifest.json');
            if (is_file($manifestPath)) {
                self::$viteManifest = json_decode(file_get_contents($manifestPath), true);
            }
        }

        return self::$viteManifest;
    }

    public static function get_template_global_variables()
    {
        return [
            'ContentLocaleShort',
            'SvgIcon',
        ];
    }
}
