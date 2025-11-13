<?php

namespace  App\Extensions;

use Bigfork\Vitesse\Vite;
use SilverStripe\Core\Extension;
use SilverStripe\View\Requirements;

class BlogInitExtension extends Extension
{
    public function onBeforeInit()
    {
        // Server Push preload headers for blog.css
        $additionalLinkHeaders = [
            sprintf(
                '<%s>; rel=preload; as=style',
                Vite::inst()->asset('src/css/blog.css')
            )
        ];
        $headers = $this->getOwner()->response->getHeaders();
        if (array_key_exists('link', $headers)) {
            $linkHeaders = explode(',', $headers['link']);
            $linkHeaders = array_merge($linkHeaders, $additionalLinkHeaders);
        } else {
            $linkHeaders = $additionalLinkHeaders;
        }
        $this->getOwner()->response->addHeader('link', implode(',', $linkHeaders));
        Requirements::css(Vite::inst()->asset('src/css/blog.css'));
    }
}
