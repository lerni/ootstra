<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\ORM\DataExtension;

class ShareCareFieldsExtension extends DataExtension
{


    public function updateCMSFields(FieldList $fields)
    {


        $message = _t('Page.ShareCareNotNeeded', 'none');
        $ShareCareNotNeededField = LiteralField::create(
            'ShareCareNotNeeded',
            sprintf(
                '<p class="alert alert-warning">%s</p>',
                $message
            )
        );
        $fields->addFieldToTab('Root.Feed_Share', $ShareCareNotNeededField, 'OGTitleCustom');

        if ($uploadField = $fields->dataFieldByName('OGImageCustom')) {
            $uploadField->setFolderName('ShareFeedImages');
        }
        if ($DescriptionField = $fields->dataFieldByName('OGDescriptionCustom')) {
            $DescriptionField->setDescription('Defaultwert ist Meta-Description oder Summary bei einem Blog-Post');
        }
    }
}
