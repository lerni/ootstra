<?php

namespace App\Schema;

use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\Control\Middleware\HTTPMiddleware;

/**
 * Injects the registry as one `<script type="application/ld+json">` into `<head>`
 * after the response has been rendered, so entities registered while rendering are included.
 */
class SchemaResponseMiddleware implements HTTPMiddleware
{
    public function process(HTTPRequest $request, callable $delegate)
    {
        $response = $delegate($request);

        if (!$response instanceof HTTPResponse || SchemaRegistry::isEmpty()) {
            return $response;
        }

        $contentType = (string) $response->getHeader('Content-Type');
        $body = (string) $response->getBody();
        if (($contentType && !str_contains($contentType, 'text/html'))
            || !preg_match('#</head\b#i', $body, $match, PREG_OFFSET_CAPTURE)
        ) {
            return $response;
        }

        $json = SchemaRegistry::getJSON(SchemaRegistry::getFinalGraph());
        $script = '<script type="application/ld+json">' . $json . "</script>\n";
        // substr_replace, not preg_replace: JSON may contain "$1"-like sequences
        $response->setBody(substr_replace($body, $script, $match[0][1], 0));

        return $response;
    }
}
