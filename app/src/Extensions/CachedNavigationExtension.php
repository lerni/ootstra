<?php

namespace App\Extensions;

use Page;
use DOMXPath;
use DOMDocument;
use SilverStripe\Core\Extension;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Security\Security;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\ORM\FieldType\DBHTMLText;

class CachedNavigationExtension extends Extension
{
    public function CachedNavigation()
    {
        $request = $this->getOwner()->getRequest();
        $userGroups = 0;
        if (Security::getCurrentUser()) {
            $userGroups = implode(',', Security::getCurrentUser()->Groups()->column('ID'));
        }
        $cacheKey = md5(implode('_', [
            Page::get()->max('LastEdited'),
            Page::get()->count(),
            $userGroups,
            Versioned::get_stage(),
        ]));
        $cache = Injector::inst()->get(CacheInterface::class . '.cacheblock');
        $content = $cache->get($cacheKey);
        if (!$content || $request->getVar('flush')) {
            $content = $this->getOwner()->renderWith('App\Includes\Navigation')->forTemplate();
            // Remove any XML declarations before caching
            $content = preg_replace('/<\?xml\s+.*?\?>\s*/s', '', $content);
            $cache->set($cacheKey, $content);
        }

        // Use DOMDocument to properly add classes to elements with data-linkingmode attributes
        $current = $this->getOwner()->data();
        $doc = new DOMDocument('1.0', 'UTF-8');
        $wrapperId = '__dom_wrapper_' . md5(uniqid('', true)) . '__';

        // Suppress warnings for HTML5 tags and load content
        libxml_use_internal_errors(true);
        $doc->loadHTML('<?xml encoding="utf-8" ?><div id="' . $wrapperId . '">' . $content . '</div>');
        libxml_clear_errors();

        $xpath = new DOMXPath($doc);

        // Mark current page
        $currentElements = $xpath->query("//*[@data-linkingmode='{$current->ID}']");
        foreach ($currentElements as $element) {
            $classes = $element->getAttribute('class');
            $element->setAttribute('class', trim($classes . ' current'));
            $element->removeAttribute('data-linkingmode');
        }

        // Mark parent pages as section
        $count = 0;
        while ($current->ParentID != 0 && $count++ < 20) {
            $sectionElements = $xpath->query("//*[@data-linkingmode='{$current->ParentID}']");
            foreach ($sectionElements as $element) {
                $classes = $element->getAttribute('class');
                $element->setAttribute('class', trim($classes . ' section expanded'));
                $element->removeAttribute('data-linkingmode');
            }
            $current = $current->Parent();
        }

        // Remove any remaining data-linkingmode attributes
        $remainingElements = $xpath->query("//*[@data-linkingmode]");
        foreach ($remainingElements as $element) {
            $element->removeAttribute('data-linkingmode');
        }

        // Get only the content of our wrapper div
        $wrapperNode = $xpath->query("//div[@id='$wrapperId']")->item(0);
        $content = '';
        if ($wrapperNode) {
            foreach ($wrapperNode->childNodes as $child) {
                $content .= $doc->saveHTML($child);
            }
        }

        return DBHTMLText::create()->setValue($content);
    }
}
