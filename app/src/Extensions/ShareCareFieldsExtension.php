<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class ShareCareFieldsExtension extends DataExtension
{


    public function updateCMSFields(FieldList $fields)
    {
        if ($uploadField = $fields->dataFieldByName('OGImageCustom')) {
            $uploadField->setFolderName('ShareFeedImages');
        }
        if ($DescriptionField = $fields->dataFieldByName('OGDescriptionCustom')) {
            $DescriptionField->setDescription('Defaultwert ist Meta-Description oder Summary bei einem Blog-Post');
            $DescriptionField->setAttribute('placeholder', $this->owner->DefaultMetaDescription());
        }
    }
}
