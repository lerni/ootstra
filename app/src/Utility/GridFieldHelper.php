<?php

namespace App\Utility;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\GridField\GridField;

class GridFieldHelper
{
    /**
     * Relations can't be used before the first write, so the GridField is built lazily.
     *
     * @param callable(): GridField $factory
     */
    public static function addIfSaved(FieldList $fields, DataObject $record, callable $factory, ?string $insertBefore = null): void
    {
        if ($record->isInDB()) {
            $fields->addFieldToTab('Root.Main', $factory(), $insertBefore);

            return;
        }

        $fields->addFieldToTab('Root.Main', LiteralField::create('firstsave', '<p style="font-weight:bold; color:#555;">' . _t('SilverStripe\CMS\Controllers\CMSMain.SaveFirst', 'none') . '</p>'), $insertBefore);
    }
}
