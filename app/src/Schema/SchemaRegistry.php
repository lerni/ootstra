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

    protected static ?object $hookOwner = null;

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

        if (isset(static::$entities[$id])) {
            // FAQ sections of one page share an @id; their questions are appended, not overwritten
            if (($data['@type'] ?? null) === 'FAQPage' && isset($data['mainEntity'], static::$entities[$id]['mainEntity'])) {
                $data['mainEntity'] = [
                    ...static::asList(static::$entities[$id]['mainEntity']),
                    ...static::asList($data['mainEntity']),
                ];
            }
            $data = array_replace_recursive(static::$entities[$id], $data);
        }

        static::$entities[$id] = $data;
    }

    protected static function asList(mixed $value): array
    {
        return is_array($value) && array_is_list($value) ? $value : [$value];
    }

    /**
     * Object whose `updateSchemaGraph(array &$graph)` hook runs before output (usually the page controller).
     */
    public static function setHookOwner(?object $owner): void
    {
        static::$hookOwner = $owner;
    }

    public static function getFinalGraph(): array
    {
        $graph = static::getGraph();
        if (static::$hookOwner && method_exists(static::$hookOwner, 'extend')) {
            static::$hookOwner->extend('updateSchemaGraph', $graph);
        }

        return $graph;
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
        static::$hookOwner = null;
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
