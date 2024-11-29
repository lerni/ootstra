<?php

namespace App\Model;

use SilverStripe\View\SSViewer;
use SilverStripe\ORM\DataObject;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\RequiredFields;

class ShortCodeSnippet extends DataObject
{
    private static $table_name = 'ShortCodeSnippet';

    private static $db = [
        'Title'       => 'Varchar',
        'Code'        => 'Text'
    ];

    private static $summary_fields = [
        'Title' => 'Titel',
        'indicateShortCode' => 'ShortCode'
    ];

    private static $indexes = [
        'Title' => [
            'type' => 'unique',
            'columns' => ['Title']
        ]
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels['Title'] = _t(__CLASS__ . '.TITLE', 'Title');
        $labels['Code'] = _t(__CLASS__ . '.CODE', 'Code');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->add(LiteralField::create('ShortCode', $this->indicateShortCode() . '<br>' . _t(__CLASS__ . '.ShortCodeDescription', 'Shortcodes can also use variables like "{$Text}" from arguments [Snippet title="Title" Text="Text"]')));

        return $fields;
    }

    public function indicateShortCode()
    {
        $code = '';
        if ($this->Title) {
            $code = '[Snippet title="' . $this->Title . '"]';
        }
        return $code;
    }

    public function getCMSValidator()
    {
        return new RequiredFields([
            'Title'
        ]);
    }

    public function validate()
    {
        $result = parent::validate();

        if (ShortCodeSnippet::get()->filter('Title', $this->Title)->exclude('ID', $this->ID)->count() > 0) {
            $result->addError(_t(__CLASS__ . '.Duplicate', 'Title must be unique'));
        }

        return $result;
    }

    public static function RenderCode($arg = [])
    {
        $snippet = ShortCodeSnippet::get()->filter('Title', $arg['title'])->first();
        if ($snippet) {
            $viewer = SSViewer::fromString($snippet->Code);
            return $viewer->process(ArrayData::create($arg));
        }
        return false;
    }
}
