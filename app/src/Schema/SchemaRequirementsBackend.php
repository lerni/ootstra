<?php

namespace App\Schema;

use SilverStripe\Control\Controller;
use SilverStripe\View\Requirements_Backend;

/**
 * Injects the registry as one `<script type="application/ld+json">` into `<head>`
 * once the full template has been rendered, so entities registered while
 * rendering are included too.
 */
class SchemaRequirementsBackend extends Requirements_Backend
{
    public function includeInHTML($content)
    {
        if (preg_match('#</head\b#', $content ?? '') && !SchemaRegistry::isEmpty()) {
            $graph = SchemaRegistry::getGraph();
            Controller::curr()?->extend('updateSchemaGraph', $graph);

            $this->insertHeadTags(
                '<script type="application/ld+json">' . SchemaRegistry::getJSON($graph) . '</script>',
                'schema-graph',
            );
        }

        return parent::includeInHTML($content);
    }
}
