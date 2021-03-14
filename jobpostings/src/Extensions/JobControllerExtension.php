<?php

namespace Kraftausdruck\Extensions;

use SilverStripe\Core\Extension;
use Kraftausdruck\Models\JobPosting;

class JobPostingControllerExtension extends Extension
{

    private static $allowed_actions = [
        'job'
    ];

    public function job()
    {
        $URLSegment = $this->owner->getRequest()->param('ID');
        $job = JobPosting::get()->filter('URLSegment', $URLSegment)->first();

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
            return $this->owner->httpError(404, _t('Kraftausdruck\Elements\ElementJobs.NotFound', 'false'));
        }
    }
}
