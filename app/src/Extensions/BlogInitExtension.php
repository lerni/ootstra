<?php

namespace  App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;
use SilverStripe\Core\Manifest\ModuleResourceLoader;

class BlogInitExtension extends Extension
{
    public function onBeforeInit()
    {
        $additionalLinkHeaders = [
            sprintf(
                '<%s>; rel=preload; as=style',
                ModuleResourceLoader::resourceURL('themes/default/dist/css/blog.css')

            )
        ];
        $headers = $this->owner->response->getHeaders();
        if (array_key_exists('link', $headers)) {
            $linkHeaders = explode(',', $headers['link']);
            $linkHeaders = array_merge($linkHeaders, $additionalLinkHeaders);
        } else {
            $linkHeaders = $additionalLinkHeaders;
        }
        $this->owner->response->addHeader('link', implode(',', $linkHeaders));
        Requirements::css(ModuleResourceLoader::resourceURL('themes/default/dist/css/blog.css'));
    }
}
