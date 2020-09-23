<?php

namespace App\Admin;

use App\Models\Location;
use App\Models\JobPosting;
use SilverStripe\Admin\ModelAdmin;
use SilverStripe\Forms\LiteralField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;


class JobsAdmin extends ModelAdmin
{

    private static $managed_models = [
        JobPosting::class,
        Location::class
    ];

    // private static $menu_icon = 'mysite/images/svg/businessman.svg';
    // app/images/svg/businessman.svg
    private static $menu_icon_class = 'font-icon-page-multiple';

    private static $url_segment = 'jobs';
    private static $menu_title = 'Jobs';

    public function getEditForm($id = null, $fields = null)
    {
        $form = parent::getEditForm($id, $fields);
        if ($this->modelClass == JobPosting::class) {

            $message = _t('App\Admin\JobsAdmin.ElementJobsNeeded', 'false');
            $form->Fields()->unshift(
                LiteralField::create(
                    'HeroNeeded',
                    sprintf(
                        '<p class="alert alert-info">%s</p>',
                        $message
                    )
                )
            );

            $grid_field = $form
                ->Fields()
                ->fieldByName($this->sanitiseClassName($this->modelClass));

            $config = $grid_field->getConfig();
            $config->addComponent(new GridFieldOrderableRows('Sort'));
        }
        return $form;
    }
}
