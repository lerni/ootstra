<?php

namespace App\Controller;

use PageController;
use SilverStripe\Core\ClassInfo;
use App\Extensions\UrlifyExtension;
use SilverStripe\Control\HTTPRequest;

class SlugHolderPageController extends PageController
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
                if ($item->hasExtension(UrlifyExtension::class)) {
                    $item->setSlugActive(true);
                }
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

    public function getPageLevel()
    {
        $level = 0;
        $parent = $this->data()->Parent();
        while ($parent && $parent->exists()) {
            $level++;
            $parent = $parent->Parent();
        }
        $level += 1; // SlugHolderPage's own level

        return $level;
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
