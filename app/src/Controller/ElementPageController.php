<?php

namespace App\Controller;

use PageController;
// use Kraftausdruck\Models\JobPosting;

class ElementPageController extends PageController
{
    protected function init()
    {
        parent::init();
    }

        // public function BetterNavigatorEditLink() {
        //     $URLSegment = $this->getRequest()->param('ID');
        //     $product = JobPosting::get()->filter('URLSegment', $URLSegment)->first();
        //     if ($product) {
        //         return $product->CMSEditLink();
        //     } else {
        //         return $this->data()->CMSEditLink();
        //     }
        // }
}
