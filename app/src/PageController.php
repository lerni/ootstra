<?php

use Bigfork\Vitesse\Vite;
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

            // Server Push preload headers for main assets
            if ($this->response) {
                $additionalLinkHeaders = [
                    sprintf(
                        '<%s>; rel=preload; as=script',
                        Vite::inst()->asset('src/js/app.js'),
                    ),
                    sprintf(
                        '<%s>; rel=preload; as=style',
                        Vite::inst()->asset('src/css/style.css'),
                    ),
                ];
                $headers = $this->response->getHeaders();
                if (array_key_exists('link', $headers)) {
                    $linkHeaders = explode(',', $headers['link']);
                    $linkHeaders = array_merge($linkHeaders, $additionalLinkHeaders);
                } else {
                    $linkHeaders = $additionalLinkHeaders;
                }
                $this->response->addHeader('link', implode(',', $linkHeaders));
            }
        }
    }
}
