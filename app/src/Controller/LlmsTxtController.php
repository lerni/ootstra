<?php

namespace App\Controller;

use SilverStripe\i18n\i18n;
use SilverStripe\Core\Convert;
use SilverStripe\ORM\DataList;
use SilverStripe\ORM\DataObject;
use SilverStripe\Control\Director;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Control\Controller;
use SilverStripe\Versioned\Versioned;
use SilverStripe\Control\HTTPResponse;
use Wilr\GoogleSitemaps\GoogleSitemap;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\Core\Injector\Injector;

/**
 * Serves /llms.txt (https://llmstxt.org) generated from everything the sitemap lists
 * (SiteTree and all GoogleSitemap::register_dataobjects() classes).
 *
 * The output is cached, the cache key changes as soon as something in the sitemap does.
 */
class LlmsTxtController extends Controller
{
    private static array $allowed_actions = [
        'index',
    ];

    /** Groups with more entries are not listed one by one, they are only counted and point to sitemap.xml */
    private static int $max_items_per_group = 60;

    /**
     * Class => section heading, the most specific matching class wins. Classes without a match are
     * headed by their plural name. Headings are translatable with the key GROUP_<LABEL IN CAPS WITHOUT SPACES>.
     */
    private static array $group_labels = [
        SiteTree::class => 'Pages',
        'SilverStripe\\Blog\\Model\\BlogPost' => 'Blog posts',
    ];

    public function index(): HTTPResponse
    {
        $cache = Injector::inst()->get(CacheInterface::class . '.LlmsTxt');
        $key = $this->cacheKey();

        $body = $cache->get($key);
        if (!is_string($body)) {
            $body = $this->buildMarkdown();
            $cache->set($key, $body);
        }

        return HTTPResponse::create($body)
            ->addHeader('Content-Type', 'text/plain; charset=utf-8')
            ->addHeader('Cache-Control', 'public, max-age=3600');
    }

    private function buildMarkdown(): string
    {
        $config = SiteConfig::current_site_config();
        $max = (int) static::config()->get('max_items_per_group');

        $lines = ['# ' . $this->clean($config->Title)];
        if ($summary = $this->clean($config->MetaDescription ?: $config->Tagline)) {
            $lines[] = '';
            $lines[] = '> ' . $summary;
        }

        $groups = [];
        foreach ($this->records() as $record) {
            $groups[$this->groupLabel($record->ClassName)][] = $record;
        }

        $collapsed = [];
        foreach ($groups as $label => $records) {
            if (count($records) > $max) {
                $collapsed[] = sprintf('%s (%d)', $label, count($records));

                continue;
            }

            $lines[] = '';
            $lines[] = '## ' . $this->clean($label);
            $lines[] = '';
            foreach ($records as $record) {
                $lines[] = $this->listItem($record);
            }
        }

        $lines[] = '';
        $lines[] = '## Optional';
        $lines[] = '';
        $lines[] = sprintf(
            '- [%s](%s): %s',
            _t(self::class . '.SITEMAP', 'XML sitemap'),
            Director::absoluteURL('sitemap.xml'),
            $collapsed
                ? _t(self::class . '.SITEMAPALL', 'Complete list of all URLs, including: {groups}', ['groups' => implode(', ', $collapsed)])
                : _t(self::class . '.SITEMAPONLY', 'Complete list of all URLs'),
        );

        return implode("\n", $lines) . "\n";
    }

    /** @return iterable<DataObject> */
    private function records(): iterable
    {
        $sitemap = GoogleSitemap::inst();

        foreach ($sitemap->getSitemaps() as $sitemapPage) {
            $className = $this->sitemapClass($sitemapPage->ClassName);
            if ($className === null) {
                continue;
            }

            $items = $sitemap->getItems($className, (int) $sitemapPage->Page);
            // Links resolve per class (e.g. UrlifyExtension without a SlugHolderPage), so the first record decides
            if (!$items->first()?->AbsoluteLink()) {
                continue;
            }

            yield from $items;
        }
    }

    private function listItem(DataObject $record): string
    {
        $title = $this->clean($record->hasField('Title') ? $record->Title : '') ?: $record->AbsoluteLink();
        $description = $record->hasField('MetaDescription') ? $this->clean($record->MetaDescription) : '';

        return sprintf(
            '- [%s](%s)%s',
            str_replace(['[', ']'], '', $title),
            $record->AbsoluteLink(),
            $description ? ': ' . $description : '',
        );
    }

    /** Changes whenever a listed record is added, removed, (un)published or edited */
    private function cacheKey(): string
    {
        $parts = [SiteConfig::current_site_config()->LastEdited, Director::absoluteBaseURL(), i18n::get_locale()];
        $lists = [Versioned::get_by_stage(SiteTree::class, 'Live')->filter('ShowInSearch', 1)];

        foreach (GoogleSitemap::inst()->getSitemaps() as $sitemapPage) {
            $className = $this->sitemapClass($sitemapPage->ClassName);
            if ($className !== null && $className !== SiteTree::class) {
                $lists[$className] = DataList::create($className);
            }
        }

        foreach ($lists as $list) {
            $parts[] = $list->count() . '@' . $list->max('LastEdited');
        }

        return md5(implode('|', $parts));
    }

    /** Label of the most specific class in group_labels the record is an instance of */
    private function groupLabel(string $className): string
    {
        $label = null;
        $depth = -1;
        foreach (static::config()->get('group_labels') as $class => $candidate) {
            if (!class_exists($class)) {
                continue;
            }

            $candidateDepth = count(class_parents($class));
            if (is_a($className, $class, true) && $candidateDepth > $depth) {
                $label = $candidate;
                $depth = $candidateDepth;
            }
        }

        if ($label === null) {
            return singleton($className)->i18n_plural_name();
        }

        return _t(self::class . '.GROUP_' . strtoupper((string) preg_replace('/\W+/', '', $label)), $label);
    }

    private function sitemapClass(string $sanitised): ?string
    {
        $className = str_replace('-', '\\', $sanitised);

        return $className !== 'GoogleSitemapRoute' && class_exists($className) ? $className : null;
    }

    private function clean(?string $text): string
    {
        return trim((string) preg_replace('/\s+/u', ' ', Convert::xml2raw((string) $text)));
    }
}
