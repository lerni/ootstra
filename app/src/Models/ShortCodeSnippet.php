<?php

namespace App\Models;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\LiteralField;
use SilverStripe\View\ViewLayerData;
use SilverStripe\View\TemplateEngine;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Validation\ValidationResult;
use SilverStripe\Forms\Validation\RequiredFieldsValidator;

class ShortCodeSnippet extends DataObject
{
    private static $table_name = 'ShortCodeSnippet';

    private static $db = [
        'Title' => 'Varchar',
        'Code' => 'Text',
    ];

    private static $summary_fields = [
        'Title' => 'Titel',
        'indicateShortCode' => 'ShortCode',
    ];

    private static $indexes = [
        'Title' => [
            'type' => 'unique',
            'columns' => ['Title'],
        ],
    ];

    public function fieldLabels($includerelations = true)
    {
        $labels = parent::fieldLabels($includerelations);
        $labels['Title'] = _t(self::class . '.TITLE', 'Title');
        $labels['Code'] = _t(self::class . '.CODE', 'Code');

        return $labels;
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->add(LiteralField::create('ShortCode', $this->indicateShortCode() . '<br>' . _t(self::class . '.ShortCodeDescription', 'Shortcodes can also use variables like "{$Text}" from arguments [Snippet title="Title" Text="Text"]')));

        return $fields;
    }

    public function indicateShortCode()
    {
        if ($this->Title) {
            return '[Snippet title="' . $this->Title . '"]';
        }

        return '';
    }

    public function getCMSValidator()
    {
        return RequiredFieldsValidator::create([
            'Title',
        ]);
    }

    public function validate(): ValidationResult
    {
        $result = parent::validate();

        if (ShortCodeSnippet::get()->filter(['Title' => $this->Title])->exclude(['ID' => $this->ID])->count() > 0) {
            $result->addError(_t(self::class . '.Duplicate', 'Title must be unique'));
        }

        return $result;
    }

    public static function RenderCode($arg = [])
    {
        $snippet = ShortCodeSnippet::get()->filter(['Title' => $arg['title']])->first();
        if ($snippet) {
            $engine = Injector::inst()->get(TemplateEngine::class);

            return $engine->renderString($snippet->Code, ViewLayerData::create($arg));
        }

        return false;
    }
}
