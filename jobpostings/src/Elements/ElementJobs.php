<?php

namespace Kraftausdruck\Elements;

use Kraftausdruck\Models\JobPosting;
use SilverStripe\Forms\LiteralField;
use DNADesign\Elemental\Models\BaseElement;

class ElementJobs extends BaseElement
{

    private static $db = [
        'Primary' => 'Boolean',
        'NoVacancies' => 'HTMLText'
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
            $PrimaryField->setTitle(_t('Kraftausdruck\Elements\ElementJobs.primary', 'Primary JobElement (linked)'));
        }

        if ($TextEditor = $fields->dataFieldByName('NoVacancies')) {
            $TextEditor->setRows(10);
            $TextEditor->addExtraClass('stacked');
        }
        $message = _t('Kraftausdruck\Admin\ElementJobs.EditJobsHint', '<a href="/admin/jobs">Create & edit</a> job-postings via jobs.');
        $fields->unshift(
            LiteralField::create(
                'EditJobs',
                sprintf(
                    '<p class="alert alert-info">%s</p>',
                    $message
                )
            )
        );

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
        $this->NoVacancies = '<p>' . _t('Kraftausdruck\Elements\ElementJobs.defaultNoVacancies', 'Thank you for your interest. We have no job openings at present.') . '</p>';
        $this->Primary = 1;
        if ($jobElements = $this->ClassName::get()->filter('Primary', 1)->count()) {
            $this->Primary = 0;
        }
        parent::populateDefaults();
    }

    public function getType()
    {
        return _t(__CLASS__ . '.BlockType', 'Jobs');
    }
}
