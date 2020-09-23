<?php

namespace App\Elements;

use App\Models\JobPosting;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\Forms\LiteralField;

class ElementJobs extends BaseElement
{

    private static $db = [
        'Primary' => 'Boolean'
    ];

    private static $defaults = [
        'AvailableGlobally' => 0
    ];

    private static $table_name = 'ElementJobs';

    private static $title = 'Job Element';

    private static $inline_editable = false;

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName('isFullWidth');

        if ($AvailableGloballyField = $fields->dataFieldByName('AvailableGlobally')) {
            $AvailableGloballyField->setDisabled(true);
        }

        if ($PrimaryField = $fields->dataFieldByName('Primary')) {
            if (!$this->Primary && $this->ClassName::get()->filter(['Primary' => 1])->count()) {
                $PrimaryJobElement = $this->ClassName::get()->filter(['Primary' => 1])->first()->AbsoluteLink();
                $PrimaryField = LiteralField::create(
                    'PrimaryIs',
                    sprintf(
                        '<p class="alert alert-info">Primary Job Element is %s</p>',
                        $PrimaryJobElement
                    )
                );
            }
            $fields->addFieldToTab('Root.Settings', $PrimaryField);
            $PrimaryField->setTitle(_t('App\Elements\ElementJobs.primary', 'false'));
        }

        return $fields;
    }

    public function getItems()
    {
        $jobs = JobPosting::get()->filter(['Active' => 1])->filterByCallback(function ($record) {
            return $record->canView();
        });
        return $jobs;
    }

    // first one should be primary unless selected differently
    public function populateDefaults()
    {
        if ($jobs = $this->ClassName::get()->count()) {
            return false;
        } else {
            return false;
        }
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'false');
    }
}
