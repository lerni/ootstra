<?php

use SilverStripe\Admin\LeftAndMain;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\CMS\Controllers\ContentController;

class PageController extends ContentController
{
    protected function init()
    {
        parent::init();

        // Only load frontend requirements if not in admin area
        if (!(Controller::curr() instanceof LeftAndMain)) {
            // Requirements::block('silverstripe/userforms:client/dist/js/jquery.min.js');
            Requirements::set_force_js_to_bottom(true);
            // Requirements::javascript(ModuleResourceLoader::resourceURL('themes/default/dist/js/app.js'), 'all', ['defer' => true, 'async' => true]);

            // Pages hidden from search (ShowInSearch = false) must not be
            // indexed. A SlugHolderPage detail view renders an item rather than
            // the (usually hidden) holder, so index based on the served item
            // when there is one — otherwise it would inherit the holder's
            // noindex. Items without a ShowInSearch field stay indexable.
            $item = $this->hasMethod('getCurrentItem') ? $this->getCurrentItem() : null;
            $subject = $item ?? $this->data();
            if ($subject->hasField('ShowInSearch') && !$subject->ShowInSearch) {
                Requirements::insertHeadTags('<meta name="robots" content="noindex">');
            }
        }
    }
}
