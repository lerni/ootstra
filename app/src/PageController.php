<?php

namespace {

    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;

    class PageController extends ContentController

    {
        protected function init()
        {
            parent::init();
            Requirements::block('//code.jquery.com/jquery-3.4.1.min.js');
            Requirements::set_force_js_to_bottom(true);
            Requirements::javascript(ModuleResourceLoader::resourceURL('themes/default/dist/js/app.js'));
            if (!$this->data()->ShowInSearch) {
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
