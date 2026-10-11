<?php

namespace App\Schema;

use Spatie\SchemaOrg\BaseType;

/**
 * Request-scoped collection of schema.org nodes, emitted as one linked `@graph`.
 * Entities are built with spatie/schema-org and merged by `@id`.
 */
class SchemaRegistry
{
    /**
     * @var array<string|int, array>
     */
    protected static array $entities = [];

    /**
     * Add an entity. Entities sharing an `@id` are merged, later values win.
     * Entities without an `@id` are appended as-is.
     */
    public static function add(BaseType|array $entity): void
    {
        $data = $entity instanceof BaseType ? $entity->toArray() : $entity;
        unset($data['@context']);

        $id = $data['@id'] ?? null;
        if (!$id) {
            static::$entities[] = $data;

            return;
        }

        static::$entities[$id] = isset(static::$entities[$id])
            ? array_replace_recursive(static::$entities[$id], $data)
            : $data;
    }

    /**
     * @param iterable<BaseType|array> $entities
     */
    public static function addAll(iterable $entities): void
    {
        foreach ($entities as $entity) {
            static::add($entity);
        }
    }

    public static function has(string $id): bool
    {
        return isset(static::$entities[$id]);
    }

    public static function remove(string $id): void
    {
        unset(static::$entities[$id]);
    }

    public static function isEmpty(): bool
    {
        return static::$entities === [];
    }

    public static function getGraph(): array
    {
        return array_values(static::$entities);
    }

    public static function flush(): void
    {
        static::$entities = [];
    }

    public static function getJSON(?array $graph = null): string
    {
        return json_encode(
            [
                '@context' => 'https://schema.org',
                '@graph' => $graph ?? static::getGraph(),
            ],
            JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR,
        );
    }
}
