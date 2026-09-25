<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Versioned\Versioned;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Populate assigns has_many/many_many relations (e.g. Link.Owner) onto records that were
 * already created & published earlier in the fixture run, so the owning cascade in
 * publishRecursive() must re-discover them via Draft to pick up the relation. CLI/task
 * contexts default to the Live reading stage though, so that cascade silently finds
 * nothing there and Live never catches up. Force Draft and republish once populate finishes.
 *
 * @extends Extension<object>
 */
class PopulatePublishRelationsExtension extends Extension
{
    public function onAfterPopulateRecords(): void
    {
        Versioned::withVersionedMode(function (): void {
            Versioned::set_stage(Versioned::DRAFT);
            SiteConfig::current_site_config()->publishRecursive();
        });
    }
}
