<?php

namespace App\GridField;

use SilverStripe\Forms\GridField\GridFieldDetailForm;
use SilverStripe\Forms\GridField\GridFieldEditButton;
use SilverStripe\Forms\GridField\GridFieldConfig_Base;
use SilverStripe\Forms\GridField\GridFieldAddNewButton;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use SilverStripe\Forms\GridField\GridFieldFilterHeader;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutocompleter;

/**
 * Many-many relation editor: edit, delete, unlink, add new, add existing and optional drag & drop sorting.
 */
class GridFieldConfig_SortableRelation extends GridFieldConfig_Base
{
    private GridFieldDeleteAction $deleteAction;

    private GridFieldDeleteAction $unlinkAction;

    /**
     * @param string|null $sortField null disables sorting
     */
    public function __construct($sortField = 'SortOrder', $itemsPerPage = 20)
    {
        parent::__construct($itemsPerPage);

        $this->deleteAction = GridFieldDeleteAction::create(false);
        $this->unlinkAction = GridFieldDeleteAction::create(true);

        $this->removeComponentsByType(GridFieldFilterHeader::class);
        $this->addComponents(
            GridFieldEditButton::create(),
            $this->deleteAction,
            $this->unlinkAction,
            GridFieldDetailForm::create(),
            GridFieldAddNewButton::create('toolbar-header-left'),
            GridFieldAddExistingAutocompleter::create('toolbar-header-right'),
        );

        if ($sortField) {
            $this->addComponent(GridFieldOrderableRows::create($sortField));
        }
    }

    public function withoutDelete(): static
    {
        $this->removeComponent($this->deleteAction);

        return $this;
    }

    public function withoutUnlink(): static
    {
        $this->removeComponent($this->unlinkAction);

        return $this;
    }

    public function setAddNewLabel(string $label): static
    {
        $this->getComponentByType(GridFieldAddNewButton::class)->setButtonName($label);

        return $this;
    }
}
