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

            if($job->MetaTitle) {
                $r['MetaTitle'] = $job->MetaTitle;
            } else {
                $r['MetaTitle'] = $job->DefaultMetaTitle();
            }
            // todo: add Default...()
            if($job->MetaDescription) {
                $r['MetaDescription'] = $job->MetaDescription;
            }

            return $r;
        } else {
            return $this->owner->httpError(404, _t(__CLASS__ . '.NotFound', 'Jobposting couldn\'t be found.'));
        }
    }
}
