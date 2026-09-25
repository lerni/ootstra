<?php

namespace App\Util;

/**
 * Recovers a Silverstripe-served image URL's ORIGINAL file, undoing whatever cropped,
 * resized or format-converted "variant" was rendered on the source page — so imports keep
 * full resolution to crop/resize locally instead of re-importing an already-lossy
 * derivative. Two Silverstripe URL schemes are handled:
 * - SS3-style: "/_resampled/<Format>Xxx/<file>" alongside the original.
 * - SS4+-style: "<name>__<Manipulation1><base64>_<Manipulation2><base64>....<ext>", where
 *   the trailing extension may itself have been rewritten (e.g. to .webp) by an
 *   "ExtRewrite" manipulation — see SilverStripe\Assets\FilenameParsing\AbstractFileIDHelper
 *   (buildFileID()/swapExtension()) and ImageManipulation::variantName() in
 *   silverstripe/assets, which this mirrors closely enough to reverse it.
 */
class ImageUrlResolver
{
    private const VARIANT_SEPARATOR = '__';

    public static function resolveOriginal(string $url): string
    {
        $resolved = self::resolveVariantFilename($url);

        return (string) preg_replace('#/_resampled/[^/]+/#', '/', $resolved);
    }

    private static function resolveVariantFilename(string $url): string
    {
        $lastSlash = strrpos($url, '/');
        if ($lastSlash === false) {
            return $url;
        }

        $dir = substr($url, 0, $lastSlash + 1);
        $filename = substr($url, $lastSlash + 1);

        $separatorPos = strpos($filename, self::VARIANT_SEPARATOR);
        if ($separatorPos === false) {
            return $url;
        }

        $name = substr($filename, 0, $separatorPos);
        $variantAndExt = substr($filename, $separatorPos + strlen(self::VARIANT_SEPARATOR));

        $extPos = strrpos($variantAndExt, '.');
        if ($extPos === false) {
            return $url;
        }

        $variant = substr($variantAndExt, 0, $extPos);
        $extension = substr($variantAndExt, $extPos + 1);

        // Sub-variants are joined with a single "_" (see AbstractFileIDHelper::swapExtension()) —
        // check in reverse for the last "ExtRewrite" applied, which carries [originalExt, variantExt].
        foreach (array_reverse(explode('_', $variant)) as $subVariant) {
            if (preg_match('/^ExtRewrite(?<base64>.+)$/', $subVariant, $matches)) {
                $decoded = self::base64UrlDecode($matches['base64']);
                if (is_array($decoded) && isset($decoded[0])) {
                    $extension = (string) $decoded[0];
                }

                break;
            }
        }

        return $dir . $name . '.' . $extension;
    }

    /** Mirrors SilverStripe\Core\Convert::base64url_decode() (silverstripe/framework) without requiring that class. */
    private static function base64UrlDecode(string $value): mixed
    {
        $base64 = strtr($value, '~_', '+/');
        $padded = str_pad($base64, strlen($base64) + (4 - strlen($base64) % 4) % 4, '=');

        $decoded = base64_decode($padded, true);
        if ($decoded === false) {
            return null;
        }

        return json_decode($decoded, true);
    }
}
