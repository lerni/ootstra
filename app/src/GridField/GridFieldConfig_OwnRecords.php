<?php

namespace App\GridField;

use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;

/**
 * Records owned by the list: edit, delete, add new and optional drag & drop sorting (no add existing / unlink).
 */
class GridFieldConfig_OwnRecords extends GridFieldConfig_Base
{
    /**
     * @param string|null $sortField null disables sorting
     */
    public function __construct($sortField = null, $itemsPerPage = 20)
    {
        parent::__construct($itemsPerPage);

        $this->removeComponentsByType(GridFieldFilterHeader::class);
        $this->addComponents(
            GridFieldEditButton::create(),
            GridFieldDeleteAction::create(false),
            GridFieldDetailForm::create(),
            GridFieldAddNewButton::create('toolbar-header-left'),
        );

        if ($sortField) {
            $this->addComponent(GridFieldOrderableRows::create($sortField));
        }
    }
}
