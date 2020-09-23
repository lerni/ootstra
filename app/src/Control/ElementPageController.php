<?php

namespace App\Controller;

use PageController;
use App\Models\JobPosting;

class ElementPageController extends PageController
{
    protected function init()
    {
        parent::init();
    }

    private static $allowed_actions = [
        'job'
    ];

    public function job()
    {
        (int)$ID = $this->getRequest()->param('ID');
        $job = JobPosting::get()->byID($ID);

        if ($job && $job->Active == 1) {

            $r['Job'] = $job;

            if ($job->JobLocations()->Count()) {
                $locations = [];
                $locations = $job->JobLocations()->Column('Town');
                $locations = implode(', ', $locations);
                $r['MetaTitle'] = $job->Title . ', ' . $locations;
            }

            return $r;
        } else {
            return $this->httpError(404, _t('App\Elements\ElementJobs.NotFound', 'false'));
        }
    }
}
