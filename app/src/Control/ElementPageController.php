<?php

namespace App\Controller;

use PageController;
use App\Models\Perso;

class ElementPageController extends PageController
{
    protected function init()
    {
        parent::init();
    }
    private static $allowed_actions = [
        'perso'
    ];

    public function perso()
    {
        $URLSegment = $this->getRequest()->param('ID');
        $perso = Perso::get()->filter('URLSegment', $URLSegment)->first();

        if ($perso) {

            $r['Perso'] = $perso;

            if ($perso->Firstname && $perso->Name) {
                $r['MetaTitle'] = $perso->Firstname . ', ' . $perso->Name;
            }

            return $r;
        } else {
            return $this->httpError(404, _t('Kraftausdruck\Elements\ElementJobs.NotFound', 'false'));
        }
    }
}
