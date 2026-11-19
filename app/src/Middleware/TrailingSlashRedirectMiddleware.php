<?php

namespace App\Middleware;

use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Control\HTTPResponse;
use SilverStripe\CMS\Controllers\OldPageRedirector;
use SilverStripe\CMS\Controllers\RootURLController;
use SilverStripe\RedirectedURLs\Model\RedirectedURL;
use SilverStripe\Control\Middleware\CanonicalURLMiddleware;
use SilverStripe\RedirectedURLs\Service\RedirectedURLService;

/**
 * Collapses trailing-slash redirect chains (e.g. /home/ -> /, /old-slug/ -> /new-slug)
 * into a single hop before CanonicalURLMiddleware strips the trailing slash.
 */
class TrailingSlashRedirectMiddleware extends CanonicalURLMiddleware
{
    public function process(HTTPRequest $request, callable $delegate): HTTPResponse
    {
        $redirect = $this->getEarlyTrailingSlashRedirect($request);
        if ($redirect) {
            return $redirect;
        }

        return parent::process($request, $delegate);
    }

    private function getEarlyTrailingSlashRedirect(HTTPRequest $request): ?HTTPResponse
    {
        if (Director::is_cli() || !$this->isEnabled() || !$this->getEnforceTrailingSlashConfig()) {
            return null;
        }

        if (Controller::config()->uninherited('add_trailing_slash')) {
            return null;
        }

        if (!in_array($request->httpMethod(), ['GET', 'HEAD'], true)) {
            return null;
        }

        $rawPath = strtok((string) Environment::getEnv('REQUEST_URI'), '?');
        if ($rawPath === false || $rawPath === '/' || !str_ends_with($rawPath, '/')) {
            return null;
        }

        $relativePath = ltrim($request->getURL(), '/');
        if ($relativePath === '') {
            return null;
        }

        $ignoredPrefixes = array_merge(['Security/'], (array) $this->getEnforceTrailingSlashConfigIgnorePaths());
        foreach ($ignoredPrefixes as $prefix) {
            $prefix = trim((string) $prefix, '/');
            if ($prefix === '') {
                continue;
            }
            if (stripos($relativePath, $prefix . '/') === 0 || strcasecmp($relativePath, $prefix) === 0) {
                return null;
            }
        }

        $trimmedPath = rtrim($relativePath, '/');

        if (class_exists(RootURLController::class) && $trimmedPath === RootURLController::get_homepage_link()) {
            $target = Director::absoluteBaseURL();
            $queryVars = $request->getVars();
            unset($queryVars['url']);
            if ($queryVars) {
                $target .= '?' . http_build_query($queryVars);
            }

            return HTTPResponse::create()->redirect($target, 301);
        }

        $hasRedirectedURLs = class_exists(RedirectedURL::class)
            && class_exists(RedirectedURLService::class)
            && DataObject::getSchema()->tablesAreReadyForClass(RedirectedURL::class);

        if ($hasRedirectedURLs) {
            $service = RedirectedURLService::create();
            $match = $service->findBestRedirectedURLMatch($request);
            if ($match) {
                return $service->getResponse($match);
            }
        }

        $hasOldPageRedirector = class_exists(SiteTree::class)
            && class_exists(OldPageRedirector::class)
            && DataObject::getSchema()->tablesAreReadyForClass(SiteTree::class);

        if ($hasOldPageRedirector) {
            $params = preg_split('|/+|', $trimmedPath);
            $page = OldPageRedirector::find_old_page($params, 0) ?: OldPageRedirector::find_old_page($params);
            if ($page) {
                $cleanPage = trim(Director::makeRelative($page) ?? '', '/');
                if ($cleanPage === '' && class_exists(RootURLController::class)) {
                    $cleanPage = Director::makeRelative(RootURLController::get_homepage_link());
                }
                if ($cleanPage !== $trimmedPath) {
                    $queryVars = $request->getVars();
                    unset($queryVars['url']);
                    $target = Controller::join_links($page, $queryVars ? '?' . http_build_query($queryVars) : null);

                    return HTTPResponse::create()->redirect($target, 301);
                }
            }
        }

        return null;
    }
}
