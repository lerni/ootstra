<?php

namespace App\Schema;

use SilverStripe\Control\Director;

/**
 * Single source of truth for schema.org `@id` strings, so every contributor
 * links to exactly the same node.
 */
class SchemaIdentifiers
{
    public static function organizationId(): string
    {
        return static::siteUrl() . '#organization';
    }

    public static function websiteId(): string
    {
        return static::siteUrl() . '#website';
    }

    public static function webPageId(string $absoluteUrl): string
    {
        return static::forUrl($absoluteUrl, 'webpage');
    }

    public static function articleId(string $absoluteUrl): string
    {
        return static::forUrl($absoluteUrl, 'article');
    }

    public static function breadcrumbId(string $absoluteUrl): string
    {
        return static::forUrl($absoluteUrl, 'breadcrumb');
    }

    public static function forUrl(string $absoluteUrl, string $fragment): string
    {
        return $absoluteUrl . '#' . $fragment;
    }

    /**
     * Absolute base URL with exactly one trailing slash.
     */
    public static function siteUrl(): string
    {
        return rtrim(Director::absoluteBaseURL(), '/') . '/';
    }
}
