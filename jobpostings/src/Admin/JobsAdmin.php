<?php

namespace Kraftausdruck\Admin;

use Kraftausdruck\Models\JobPosting;
use Kraftausdruck\Models\JobDefaults;
use App\Models\Point;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Control\Director;
use SilverStripe\Forms\LiteralField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class JobsAdmin extends ModelAdmin
{

    private static $managed_models = [
        JobPosting::class,
        JobDefaults::class,
        // Point::class
    ];

    private static $menu_icon_class = 'font-icon-torso';

    private static $url_segment = 'jobs';
    private static $menu_title = 'Jobs';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        if ($this->modelClass == JobPosting::class)
        {
            if(Director::isLive())
            {
                $message = _t('Kraftausdruck\Admin\JobsAdmin.ElementJobsNeeded',
                    'none',
                    ['BaseURL' => Director::absoluteBaseURL()]
                );
                $form->Fields()->unshift(
                    LiteralField::create(
                        'ElementJobsNeeded',
                        sprintf(
                            '<p class="alert alert-info">%s</p>',
                            $message
                        )
                    )
                );
            }

            $grid_field = $form
                ->Fields()
                ->fieldByName($this->sanitiseClassName($this->modelClass));

            $config = $grid_field->getConfig();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
        }
        return $form;
    }
}
