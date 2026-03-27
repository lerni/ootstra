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

            // UserDefinedFormController would interfere and falsely output noindex
            if (!$this->data()->ShowInSearch && array_key_exists('ShowInSearch', $this->record)) {
                Requirements::insertHeadTags('<meta name="robots" content="noindex">');
            }
        }
    }
}
