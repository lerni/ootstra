<?php

namespace App\Controller;

use SilverStripe\Core\ClassInfo;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\CMS\Controllers\ContentController;

class SlugHolderPageController extends ContentController
{
    private static $url_handlers = [
        '$Slug!' => 'view',
    ];

    private static $allowed_actions = [
        'view',
    ];

    private $currentItem;

    public function view(HTTPRequest $request)
    {
        $urlSegment = $request->param('Slug');
        $class = $this->data()->ManagedModel;
        if ($urlSegment && $class && class_exists($class)) {
            $item = $class::get()->filter('URLSegment', $urlSegment)->first();
            if ($item) {
                $this->currentItem = $item;
                $shortName = ClassInfo::shortName($class);

                return $this->customise(['CurrentItem' => $item])->renderWith([
                    'App/Models/SlugHolderPage_' . $shortName,
                    'App/Models/SlugHolderPage',
                    'Page',
                ]);
            }
        }

        $this->httpError(404);
    }

    public function index(HTTPRequest $request)
    {
        $parent = $this->data()->Parent();
        if ($parent) {
            return $this->redirect($parent->Link());
        }

        return $this->httpError(404);
    }

    public function getCurrentItem()
    {
        return $this->currentItem;
    }

    public function BetterNavigatorEditLink()
    {
        if ($this->currentItem) {
            $link = $this->currentItem->getCMSEditLink();
            if ($link) {
                return $link;
            }
        }

        return $this->data()->getCMSEditLink();
    }
}
