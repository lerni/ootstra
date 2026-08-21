<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;

/**
 * Link records are edited inline via the LinkField React modal, not on a CMS tree page, so
 * FluentExtension's "Locales" GridField tab has no working CMSEditLink to navigate to and just
 * clutters/breaks the modal - remove it.
 */
class LinkFluentCleanupExtension extends Extension
{
    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName('RecordLocales');
    }
}
