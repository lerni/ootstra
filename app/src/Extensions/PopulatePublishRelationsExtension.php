<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Versioned\Versioned;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Populate assigns has_many/many_many relations (e.g. Link.Owner) via a direct
 * foreign-key write that bypasses Versioned::write(), so the Draft stage ends up
 * linked but Live does not. Republish the affected records once populate finishes.
 *
 * @extends Extension<object>
 */
class PopulatePublishRelationsExtension extends Extension
{
    public function onAfterPopulateRecords(): void
    {
        $siteConfig = SiteConfig::current_site_config();

        foreach (['ServiceNavigationItems', 'TermsNavigationItems'] as $relation) {
            foreach ($siteConfig->{$relation}() as $link) {
                if ($link->hasExtension(Versioned::class)) {
                    $link->publishRecursive();
                }
            }
        }
    }
}
