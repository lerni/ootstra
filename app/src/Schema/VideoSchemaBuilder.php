<?php

namespace App\Schema;

use Throwable;
use GuzzleHttp\Client;
use Spatie\SchemaOrg\Schema;
use Psr\SimpleCache\CacheInterface;
use SilverStripe\Core\Injector\Injector;

/**
 * Adds a VideoObject for every YouTube iframe found in the rendered HTML.
 * Scanning the output (instead of hooking the embed shortcode) also covers cached
 * shortcode results, cache blocks and EmbedObject videos.
 */
class VideoSchemaBuilder
{
    private const EMBED_PATTERN = '#<iframe\b[^>]*\bsrc=["\']https?://(?:www\.)?(?:youtube(?:-nocookie)?\.com/embed|youtu\.be)/([A-Za-z0-9_-]{11})#i';

    private const CACHE_OK = 2592000;

    // Retry later instead of hammering YouTube on every request
    private const CACHE_FAILED = 3600;

    public static function register(string $html): void
    {
        if (!preg_match_all(self::EMBED_PATTERN, $html, $matches)) {
            return;
        }

        $pageUrl = self::pageUrl();
        if (!$pageUrl) {
            return;
        }

        $videoIds = [];
        foreach (array_unique($matches[1]) as $youtubeId) {
            $video = self::build($youtubeId, $pageUrl);
            if ($video) {
                SchemaRegistry::add($video);
                $videoIds[] = ['@id' => $video->getProperty('@id')];
            }
        }

        if ($videoIds) {
            SchemaRegistry::add(['@id' => SchemaIdentifiers::webPageId($pageUrl), 'video' => $videoIds]);
        }
    }

    private static function pageUrl(): ?string
    {
        foreach (SchemaRegistry::getGraph() as $entity) {
            if (($entity['@type'] ?? null) === 'WebPage' && !empty($entity['url'])) {
                return $entity['url'];
            }
        }

        return null;
    }

    private static function build(string $youtubeId, string $pageUrl): ?\Spatie\SchemaOrg\VideoObject
    {
        $meta = self::metadata($youtubeId);
        if (!$meta) {
            return null;
        }

        return Schema::videoObject()
            ->setProperty('@id', SchemaIdentifiers::forUrl($pageUrl, 'video-' . $youtubeId))
            ->name($meta['name'])
            ->description($meta['description'])
            ->thumbnailUrl($meta['thumbnailUrl'])
            ->uploadDate($meta['uploadDate'])
            ->duration($meta['duration'] ?? null)
            ->embedUrl('https://www.youtube.com/embed/' . $youtubeId);
    }

    /**
     * @return array{name: string, description: string, thumbnailUrl: string, uploadDate: string, duration?: string}|null
     */
    private static function metadata(string $youtubeId): ?array
    {
        $cache = Injector::inst()->get(CacheInterface::class . '.VideoSchema');
        $key = 'yt_' . $youtubeId . '_' . SchemaBuilder::language();
        if ($cache->has($key)) {
            return $cache->get($key) ?: null;
        }

        $meta = self::fetch($youtubeId);
        $cache->set($key, $meta ?? false, $meta ? self::CACHE_OK : self::CACHE_FAILED);

        return $meta;
    }

    private static function fetch(string $youtubeId): ?array
    {
        $client = new Client([
            'timeout' => 3,
            'connect_timeout' => 2,
            'headers' => ['User-Agent' => 'Mozilla/5.0 (compatible; SchemaVideoFetcher)', 'Accept-Language' => SchemaBuilder::language()],
        ]);
        $watchUrl = 'https://www.youtube.com/watch?v=' . $youtubeId;

        try {
            $oembed = json_decode((string) $client->get('https://www.youtube.com/oembed', [
                'query' => ['format' => 'json', 'url' => $watchUrl],
            ])->getBody(), true);
            $page = (string) $client->get($watchUrl)->getBody();
        } catch (Throwable) {
            return null;
        }

        // oEmbed has no upload date, which Google requires; the watch page exposes it as microdata
        $uploadDate = self::itemprop($page, 'uploadDate');
        if (empty($oembed['title']) || empty($oembed['thumbnail_url']) || !$uploadDate) {
            return null;
        }

        return [
            'name' => $oembed['title'],
            'description' => self::itemprop($page, 'description') ?: $oembed['title'],
            'thumbnailUrl' => $oembed['thumbnail_url'],
            'uploadDate' => $uploadDate,
            'duration' => self::itemprop($page, 'duration'),
        ];
    }

    private static function itemprop(string $html, string $name): ?string
    {
        if (!preg_match('#<meta itemprop="' . $name . '" content="([^"]*)"#', $html, $m)) {
            return null;
        }

        return trim(html_entity_decode($m[1], ENT_QUOTES | ENT_HTML5)) ?: null;
    }
}
