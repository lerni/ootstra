<?php

namespace App\Extensions;

use SilverStripe\Forms\FieldList;
use SilverStripe\Core\Extension;

class ShareCareFieldsExtension extends Extension
{
    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName([
            'PinterestImageCustom'
        ]);

        if ($uploadField = $fields->dataFieldByName('OGImageCustom')) {
            $uploadField->setFolderName('ShareFeedImages');
        }
        if ($DescriptionField = $fields->dataFieldByName('OGDescriptionCustom')) {
            $DescriptionField->setDescription(_t('\Page.OGDescriptionCustomDescription', 'Default value is "Meta Description" or "Summary" for a "Blog-post"'));
            $DescriptionField->setAttribute('placeholder', $this->owner->DefaultMetaDescription());
        }
    }
}
