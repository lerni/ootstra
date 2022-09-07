<?php

namespace {

    use App\Models\Perso;
    use SilverStripe\CMS\Controllers\ContentController;
    use SilverStripe\View\Requirements;
    use SilverStripe\Core\Manifest\ModuleResourceLoader;

    class PageController extends ContentController
    {
        private static $allowed_actions = [
            'perso'
        ];

        protected function init()
        {
            parent::init();
            // Requirements::block('silverstripe/userforms:client/dist/js/jquery.min.js');
            Requirements::set_force_js_to_bottom(true);
            Requirements::javascript(ModuleResourceLoader::resourceURL('themes/default/dist/js/app.js'), 'all', ['defer' => true, 'async' => true]);
            // UserDefinedFormController would interfere and falsely output noindex
            if (!$this->data()->ShowInSearch && array_key_exists('ShowInSearch', $this->record)) {
                Requirements::insertHeadTags('<meta name="robots" content="noindex">');
            }
            if ($this->response) {
                $additionalLinkHeaders = [
                    sprintf(
                        '<%s>; rel=preload; as=script',
                        ModuleResourceLoader::resourceURL('/_resources/themes/default/dist/js/app.js')
                    ),
                    sprintf(
                        '<%s>; rel=preload; as=style',
                        ModuleResourceLoader::resourceURL('/_resources/themes/default/dist/css/style.css')
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


        // todo extension
        public function perso()
        {
            $URLSegment = $this->getRequest()->param('ID');
            $perso = Perso::get()->filter('URLSegment', $URLSegment)->first();

            if ($perso) {

                $r['Perso'] = $perso;
                $r['Breadcrumbs'] = $perso->Breadcrumbs();

                if ($perso->Firstname && $perso->Name) {
                    $r['MetaTitle'] = $perso->Firstname . ', ' . $perso->Name;
                }

                return $r;
            } else {
                return $this->httpError(404, _t('Kraftausdruck\Elements\ElementJobs.NotFound', 'false'));
            }
        }
    }
}
