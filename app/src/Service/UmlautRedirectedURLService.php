<?php

namespace App\Service;

use SilverStripe\Core\Convert;
use SilverStripe\Core\Extensible;
use SilverStripe\Control\Director;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Model\List\ArrayList;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\RedirectedURLs\Support\Arr;
use SilverStripe\RedirectedURLs\Support\StatusCode;
use SilverStripe\RedirectedURLs\Model\RedirectedURL;
use SilverStripe\RedirectedURLs\Service\RedirectedURLInterface;

/**
 * Custom RedirectedURLService with Umlaut support
 *
 * This class extends the default RedirectedURLService to properly handle URLs with German umlauts
 * and other special characters by normalizing both the request URL and database entries for comparison.
 */
class UmlautRedirectedURLService implements RedirectedURLInterface
{
    use Extensible;
    use Configurable;
    use Injectable;

    /**
     * Normalize a URL for comparison by handling URL encoding/decoding
     * This ensures umlauts work both ways - encoded in requests and unencoded in database
     */
    private function normalizeUrlForComparison(string $url): array
    {
        $normalized = [];

        // Add the original URL (as-is)
        $normalized[] = strtolower($url);

        // Add URL decoded version (to handle encoded umlauts from browser)
        $decoded = urldecode($url);
        if ($decoded !== $url) {
            $normalized[] = strtolower($decoded);
        }

        // Add URL encoded version (to handle database entries with raw umlauts)
        $encoded = $this->encodeUmlautsOnly($url);
        if ($encoded !== $url) {
            $normalized[] = strtolower($encoded);
        }

        return array_unique($normalized);
    }

    /**
     * Encode only German umlauts and common special characters, leave the rest as-is
     */
    private function encodeUmlautsOnly(string $url): string
    {
        $replacements = [
            'ä' => '%C3%A4',
            'ö' => '%C3%B6',
            'ü' => '%C3%BC',
            'Ä' => '%C3%84',
            'Ö' => '%C3%96',
            'Ü' => '%C3%9C',
            'ß' => '%C3%9F',
            'é' => '%C3%A9',
            'è' => '%C3%A8',
            'à' => '%C3%A0',
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $url);
    }

    public function findBestRedirectedURLMatch(HTTPRequest $request): ?RedirectedURL
    {
        $base = $request->getURL();
        $getVars = Arr::toLowercase($request->getVars());

        // Get all possible normalized versions of the base URL
        $baseVariants = $this->normalizeUrlForComparison($base);

        /** @var ArrayList|RedirectedURL[] $listPotentials */
        $listPotentials = new ArrayList();

        // Find all the RedirectedURL objects where the base URL matches any variant
        foreach ($baseVariants as $baseVariant) {
            $SQL_base = Convert::raw2sql(rtrim($baseVariant, '/'));
            $potentials = RedirectedURL::get()->filter(['FromBase' => '/' . $SQL_base])->sort(['FromQuerystring' => 'DESC']);

            foreach ($potentials as $potential) {
                // Avoid duplicates
                $exists = false;
                foreach ($listPotentials as $existing) {
                    if ($existing->ID === $potential->ID) {
                        $exists = true;

                        break;
                    }
                }
                if (!$exists) {
                    $listPotentials->push($potential);
                }
            }
        }

        // Find any matching FromBase elements terminating in a wildcard /*
        foreach ($baseVariants as $baseVariant) {
            $baseParts = explode('/', $baseVariant);

            for ($pos = count($baseParts) - 1; $pos >= 0; --$pos) {
                $baseStr = implode('/', array_slice($baseParts, 0, $pos));
                $basePart = Convert::raw2sql($baseStr . '/*');
                $basePots = RedirectedURL::get()->filter(['FromBase' => '/' . $basePart])->sort(['FromQuerystring' => 'DESC']);

                foreach ($basePots as $basePot) {
                    // If the To URL ends in a wildcard /*, append the remaining request URL elements
                    if ($basePot->RedirectionType === 'External' && str_ends_with($basePot->To, '/*')) {
                        $basePot->To = substr($basePot->To, 0, -2) . substr($base, strlen($baseStr));
                    }

                    // Avoid duplicates
                    $exists = false;
                    foreach ($listPotentials as $existing) {
                        if ($existing->ID === $basePot->ID) {
                            $exists = true;

                            break;
                        }
                    }
                    if (!$exists) {
                        $listPotentials->push($basePot);
                    }
                }
            }
        }

        // If there are no potential matches, then we can exit early and return null
        if ($listPotentials->count() === 0) {
            return null;
        }

        $matched = null;

        // Then check the get vars, ignoring any additional get vars that this URL may have
        foreach ($listPotentials as $potential) {
            $allVarsMatch = true;

            if ($potential->FromQuerystring) {
                $reqVars = [];
                parse_str($potential->FromQuerystring, $reqVars);

                foreach ($reqVars as $k => $v) {
                    if (!$v) {
                        continue;
                    }

                    if (!isset($getVars[$k]) || $v != $getVars[$k]) {
                        $allVarsMatch = false;

                        break;
                    }
                }
            }

            if ($allVarsMatch) {
                $matched = $potential;

                break;
            }
        }

        // If we found a match, we return it - otherwise we return null to indicate that no match was found
        return $matched;
    }

    public function getResponse(RedirectedURL $redirect): HTTPResponse
    {
        return HTTPResponse::create()
            ->redirect(Director::absoluteURL($redirect->Link() ?? ''), StatusCode::getRedirectCode($redirect));
    }
}
