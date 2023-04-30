<?php

namespace App\Extensions;

use DOMDocument;
use SilverStripe\i18n\i18n;
use SilverStripe\ORM\ArrayList;
use SilverStripe\Core\Extension;
use SilverStripe\View\ArrayData;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use SilverStripe\View\Parsers\URLSegmentFilter;
use League\CommonMark\GithubFlavoredMarkdownConverter;

class FieldExtension extends Extension
{

    private static $casting = [
        'Markdowned' => 'HTMLFragment',
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
}
