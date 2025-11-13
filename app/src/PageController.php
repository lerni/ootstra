<?php

use App\Models\Perso;
use Bigfork\Vitesse\Vite;
use SilverStripe\Admin\LeftAndMain;
use SilverStripe\View\Requirements;
use SilverStripe\Control\Controller;
use SilverStripe\CMS\Controllers\ContentController;

class PageController extends ContentController
{
    private static $allowed_actions = [
        'perso'
    ];

    protected function init()
    {
        parent::init();

        // Only load frontend requirements if not in admin area
        if (!(Controller::curr() instanceof LeftAndMain)) {
            // Requirements::block('silverstripe/userforms:client/dist/js/jquery.min.js');
            Requirements::set_force_js_to_bottom(true);
            // Requirements::javascript(ModuleResourceLoader::resourceURL('themes/default/dist/js/app.js'), 'all', ['defer' => true, 'async' => true]);

            // UserDefinedFormController would interfere and falsely output noindex
            if (!$this->data()->ShowInSearch && array_key_exists('ShowInSearch', $this->record)) {
                Requirements::insertHeadTags('<meta name="robots" content="noindex">');
            }

            // Server Push preload headers for main assets
            if ($this->response) {
                $additionalLinkHeaders = [
                    sprintf(
                        '<%s>; rel=preload; as=script',
                        Vite::inst()->asset('src/js/app.js')
                    ),
                    sprintf(
                        '<%s>; rel=preload; as=style',
                        Vite::inst()->asset('src/css/style.css')
                    )
                ];
                $headers = $this->response->getHeaders();
                if (array_key_exists('link', $headers)) {
                    $linkHeaders = explode(',', $headers['link']);
                    $linkHeaders = array_merge($linkHeaders, $additionalLinkHeaders);
                } else {
                    $linkHeaders = $additionalLinkHeaders;
                }
                $this->response->addHeader('link', implode(',', $linkHeaders));
            }
        }
    }

    // todo extension
    public function perso()
    {
        $URLSegment = $this->getRequest()->param('ID');
        $perso = Perso::get()->filter('URLSegment', $URLSegment)->first();

        if ($perso) {

            $r['Perso'] = $perso;
            $r['Breadcrumbs'] = $perso->Breadcrumbs();

            if ($perso->Firstname && $perso->Lastname) {
                $r['MetaTitle'] = $perso->Firstname . ', ' . $perso->Lastname;
            }

            return $r;
        }
        return $this->httpError(404, _t('Kraftausdruck\Elements\ElementJobs.NotFound', 'false'));
    }
}
