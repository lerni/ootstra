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

    public function PerLineText($start = 0)
    {
        $r = ArrayList::create();

        if (is_numeric($start) && $start) {
            $start = (int)$start;
        }

        if ($this->owner->value) {
            $stringwithnoemptylines = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $this->owner->value);
            $lines = explode(PHP_EOL, $stringwithnoemptylines);
            $i = 0;
            foreach ($lines as $l) {
                if ($start <= ($i + 1)) {
                    if ($l != "") {
                        $r->push(ArrayData::create(['Item' => $l]));
                    }
                }
                $i++;
            }
        }
        return $r;
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

    public function Markdowned() {
        if ($this->owner->value) {
            $converter = new GithubFlavoredMarkdownConverter();
            $html = $converter->convertToHtml($this->owner->value);
            return $html->getContent();
        }
    }

    // Use {$Content.TrimEmbed} in template, for this to trigger
    // themes/default/templates/SilverStripe/View/Shortcodes/EmbedShortcodeProvider_video.ss
    public function TrimEmbed() {
        if ($vidSrc = $this->owner->value) {

            $dom = new DOMDocument();
            $dom->loadHTML($vidSrc);
            $iframe = $dom->getElementsByTagName("iframe");
            $iFrameSrc = $iframe->item(0)->getAttribute('src');

            // trim youtube embeds
            if (str_contains($iFrameSrc, 'youtube')) {

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
                if (isset($url_parts['query'])) {
                    parse_str($url_parts['query'], $params);
                } else {
                    $params = [];
                }

                $queryStrings = [
                    "rel" => 0,
                    "controls" => 0,
                    "showinfo" => 0
                ];

                foreach ($queryStrings as $key => $value) {
                    $params[$key] = $value;
                }

                $queryString =  http_build_query($params);

                $iFrameSrc = (isset($url_parts['scheme']) ? "{$url_parts['scheme']}:" : '') .
                    ((isset($url_parts['user']) || isset($url_parts['host'])) ? '//' : '') .
                    (isset($url_parts['user']) ? "{$url_parts['user']}" : '') .
                    (isset($url_parts['pass']) ? ":{$url_parts['pass']}" : '') .
                    (isset($url_parts['user']) ? '@' : '') .
                    (isset($url_parts['host']) ? "{$url_parts['host']}" : '') .
                    (isset($url_parts['port']) ? ":{$url_parts['port']}" : '') .
                    (isset($url_parts['path']) ? "{$url_parts['path']}" : '') .
                    '?' . $queryString .
                    (isset($url_parts['fragment']) ? "#{$url_parts['fragment']}" : '');

                $iframe->item(0)->setAttribute('src', $iFrameSrc);
            }

            $vidSrc = $dom->saveHTML($iframe->item(0));

            return $vidSrc;
        }
    }
}
