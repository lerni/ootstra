<?php

namespace App\Extensions;

use DOMDocument;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Extension;
use SilverStripe\View\ArrayData;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use SilverStripe\SiteConfig\SiteConfig;
use libphonenumber\NumberParseException;
use nathancox\EmbedField\Model\EmbedObject;
use SilverStripe\View\Parsers\URLSegmentFilter;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class FieldExtension extends Extension
{

    private static $casting = [
        'Markdowned' => 'HTMLFragment',
        'TrimEmbed' => 'HTMLFragment'
    ];

    public function CountLink()
    {
        $stringwithnoemptylines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->owner->value);
        if (empty($stringwithnoemptylines)) {
            return false;
        }
        $dom = new DOMDocument();
        @$dom->loadHTML($stringwithnoemptylines);
        $links = $dom->getElementsByTagName("a")->length;
        return $links;
    }

    public function Length()
    {
        if ($this->owner->value) {
            return strlen($this->owner->value);
        }
    }

    public function PerLineText($start = 0, $max = 0, $string = 0)
    {
        $r = ArrayList::create();

        if ($this->owner->value) {
            $stringwithnoemptylines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->owner->value);
            $lines = explode(PHP_EOL, $stringwithnoemptylines);
            $i = 0;
            $c = 0;
            foreach ($lines as $l) {
                if (
                    $l != "" &&
                    (int)$start <= ($i + 1) &&
                    ($c < (int)$max || (int)$max == 0)
                ) {
                    $r->push(ArrayData::create(['Item' => $l]));
                    $c++;
                }
                $i++;
            }
        }
        if ($string !== 0) {
            $string = '';
            foreach ($r as $line) {
                $string .= $line->Item . PHP_EOL;
            }
            return (string)$string;
        } else {
            return $r;
        }
    }

    public function URLEnc()
    {
        $filter = new URLSegmentFilter();
        return $filter->filter($this->owner->value);
    }

    public function TelEnc($schema = '')
    {
        $trimedTel = trim(preg_replace('/\s+/', '', $this->owner->value));

        if ($schema == '') {
            $schema = i18n::config()->uninherited('default_locale');
            $schemaArray = explode('_', $schema);
            $schema = end($schemaArray);
        }

        $phoneUtil = PhoneNumberUtil::getInstance();

        if ($trimedTel && $schema) {
            try {
                $NumberProto = $phoneUtil->parse($trimedTel, $schema);
                // if ($phoneUtil->isValidNumber($numberProto)) {
            } catch (NumberParseException $e) {
                user_error('Tel Number parse exception ' . $e, E_USER_WARNING);
                return false;
            }
        }

        if (isset($NumberProto)) {
            $number = stripslashes($phoneUtil->format($NumberProto, PhoneNumberFormat::INTERNATIONAL));
            $number = trim(preg_replace('/\s+/', '', $number));
            $number = str_replace('+', '', $number);
            return '00' . $number;
        }
    }

    public function Markdowned()
    {
        if ($this->owner->value) {
            $converter = new GithubFlavoredMarkdownConverter();
            $html = $converter->convertToHtml($this->owner->value);
            return $html->getContent();
        }
    }

    // Use {$Content.TrimEmbed} in template, for this to trigger
    // themes/default/templates/SilverStripe/View/Shortcodes/EmbedShortcodeProvider_video.ss
    public function TrimEmbed()
    {
        if ($vidSrc = $this->owner->value) {

            $dom = new DOMDocument();
            $dom->loadHTML($vidSrc);
            $iframe = $dom->getElementsByTagName("iframe");
            $iFrameSrc = $iframe->item(0)->getAttribute('src');

            // lazy load anyways
            $iframe->item(0)->setAttribute('loading', 'lazy');

            // set aspect ratio
            $iFrameWidth = $iframe->item(0)->getAttribute('width');
            $iframe->item(0)->removeAttribute('width');
            $iFrameHeight = $iframe->item(0)->getAttribute('height');
            $iframe->item(0)->removeAttribute('height');
            $iFrameStyle = 'width: 100%; aspect-ratio: ' . $iFrameWidth . '/' . $iFrameHeight . ' !important;';
            $iframe->item(0)->setAttribute('style', $iFrameStyle);

            $url_parts = parse_url($iFrameSrc);

            // parm trimming form youtube embeds
            if (str_contains($iFrameSrc, 'youtube')) {
                if (isset($url_parts['query'])) {
                    parse_str($url_parts['query'], $params);
                } else {
                    $params = [];
                }

                $embedCFG = EmbedObject::config();

                $queryStrings = $embedCFG->get('YTqueryStringsDefaults');
                if (is_array($queryStrings)) {
                    foreach ($queryStrings as $key => $value) {
                        $params[key($value)] = $value[key($value)];
                    }
                    $queryString = http_build_query($params);
                    $url_parts['query'] = $queryString;
                }

                $YTEnhancedPrivacy = $embedCFG->get('YTEnhancedPrivacy');
                if ($YTEnhancedPrivacy) {
                    $YTEnhancedPrivacyLink = $embedCFG->get('YTEnhancedPrivacyLink');
                    $url_parts['host'] = $YTEnhancedPrivacyLink;
                }
            }

            $iFrameSrc = $this->unparse_url($url_parts);

            $iframe->item(0)->setAttribute('src', $iFrameSrc);


            $vidSrc = $dom->saveHTML($iframe->item(0));

            return $vidSrc;
        }
    }

    function unparse_url($parsed_url)
    {
        $scheme   = isset($parsed_url['scheme']) ? $parsed_url['scheme'] . '://' : '';
        $host     = isset($parsed_url['host']) ? $parsed_url['host'] : '';
        $port     = isset($parsed_url['port']) ? ':' . $parsed_url['port'] : '';
        $user     = isset($parsed_url['user']) ? $parsed_url['user'] : '';
        $pass     = isset($parsed_url['pass']) ? ':' . $parsed_url['pass']  : '';
        $pass     = ($user || $pass) ? "$pass@" : '';
        $path     = isset($parsed_url['path']) ? $parsed_url['path'] : '';
        $query    = isset($parsed_url['query']) ? '?' . $parsed_url['query'] : '';
        $fragment = isset($parsed_url['fragment']) ? '#' . $parsed_url['fragment'] : '';

        return "$scheme$user$pass$host$port$path$query$fragment";
    }
}
