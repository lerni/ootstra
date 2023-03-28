<?php

namespace App\Elements;

use DNADesign\Elemental\Models\BaseElement;

class ElementIframe extends BaseElement
{
    private static $db = [
        'IframeLink' => 'Text'
    ];


    private static $table_name = 'ElementIframe';

    private static $title = 'iFrame';

    private static $description = 'iFrame Element';

    private static $singular_name = 'iFrame';

    private static $plural_name = 'iFrames';

    private static $icon = 'font-icon-block-external-link';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'BackgroundColor'
        ]);

        return $fields;
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'iFrame');
    }
}
