<?php

namespace App\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldPaginator;

/**
 * Adds pagination (prev/next) to elements
 */
class ElementalAreaConfigExtension extends Extension
{
    protected function updateConfig()
    {
        $this->getOwner()->addComponent(GridFieldPaginator::create());
        $this->getOwner()->getComponentByType(GridFieldDetailForm::class)->setShowPagination(true);
    }
}
