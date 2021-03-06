<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;

    class PageController extends ContentController
    {
        private static $allowed_actions = [];

        protected function init()
        {
            parent::init();
            Requirements::block('silverstripe/userforms:client/dist/js/jquery.min.js');
            Requirements::set_force_js_to_bottom(true);
            Requirements::javascript(ModuleResourceLoader::resourceURL('themes/default/dist/js/app.js'), 'all',['defer' => true, 'async' => true]);
            // UserDefinedFormController would interfere and falsely output noindex
            if (!$this->data()->ShowInSearch && array_key_exists('ShowInSearch', $this->record)) {
                Requirements::insertHeadTags('<meta name="robots" content="noindex">');
            }
            if ($this->response) {
                $this->response->addHeader('Link', implode(',', [
                    sprintf(
                        '<%s>; rel=preload; as=script',
                        ModuleResourceLoader::resourceURL('/_resources/themes/default/dist/js/app.js')
                    ),
                    sprintf(
                        '<%s>; rel=preload; as=style',
                        ModuleResourceLoader::resourceURL('/_resources/themes/default/dist/css/style.css')
                    )
                ]));
            }
        }
    }
}
