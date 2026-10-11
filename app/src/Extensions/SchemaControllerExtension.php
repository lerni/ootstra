<?php

namespace App\Extensions;

use App\Schema\SchemaBuilder;
use App\Schema\SchemaRegistry;
use Spatie\SchemaOrg\BaseType;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use App\Schema\SchemaIdentifiers;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\CMS\Model\RedirectorPage;
use SilverStripe\CMS\Controllers\ContentController;

/**
 * Collects all schema.org entities of a request into {@see SchemaRegistry}.
 * Emission as a single JSON-LD `@graph` happens in {@see \App\Schema\SchemaRequirementsBackend}.
 *
 * Any DataObject/element may contribute by implementing
 * `provideSchemaEntities(): iterable` returning spatie/schema-org types (or arrays).
 *
 * Other modules can alter the final graph via `updateSchemaGraph(array &$graph)`
 * on the current controller.
 *
 * @extends Extension<ContentController>
 */
class SchemaControllerExtension extends Extension
{
    public function onBeforeInit(): void
    {
        SchemaRegistry::flush();
    }

    public function onAfterInit(): void
    {
        $owner = $this->getOwner();
        $page = $owner->hasMethod('data') ? $owner->data() : null;
        if ($page instanceof ErrorPage) {
            return;
        }

        SchemaRegistry::add(SchemaBuilder::organization());
        SchemaRegistry::add(SchemaBuilder::website());

        if (!$page instanceof DataObject || !$page->hasMethod('AbsoluteLink')) {
            return;
        }

        // Detail pages of a slug holder register their own WebPage once the item is resolved
        if (!$owner->hasMethod('getCurrentItem')) {
            $this->registerSubject($page, $page->AbsoluteLink(), $this->pageBreadcrumbs($page));
            $this->registerSubjectEntities($page, $page->AbsoluteLink());
        }

        $this->registerElements($page);
    }

    /**
     * Registers WebPage, BreadcrumbList and contributed entities of a managed item
     * (e.g. Perso) that is rendered below a holder page.
     */
    public function registerSchemaForItem(DataObject $item, DataObject $holder): void
    {
        $url = $item->hasMethod('AbsoluteLink') ? $item->AbsoluteLink() : null;
        if (!$url) {
            return;
        }

        // Same trail as the rendered breadcrumbs; fall back to holder + item
        $breadcrumbs = $item->hasMethod('getBreadcrumbItems')
            ? $this->pageBreadcrumbs($item)
            : [...$this->pageBreadcrumbs($holder), ['name' => (string) $item->getTitle(), 'url' => $url]];

        $this->registerSubject($item, $url, $breadcrumbs);
        $this->registerSubjectEntities($item, $url);
    }

    /**
     * The first entity the page's subject provides is its main entity;
     * element contributions (e.g. FAQ) stay secondary.
     */
    protected function registerSubjectEntities(DataObject $subject, string $url): void
    {
        if (!$subject->hasMethod('provideSchemaEntities')) {
            return;
        }

        $entities = array_values(array_map(
            fn ($entity) => $entity instanceof BaseType ? $entity->toArray() : $entity,
            iterator_to_array($subject->provideSchemaEntities() ?: [], false),
        ));

        $webPageId = SchemaIdentifiers::webPageId($url);
        $mainId = $entities[0]['@id'] ?? null;
        if ($mainId) {
            $entities[0]['mainEntityOfPage'] ??= ['@id' => $webPageId];
            SchemaRegistry::add(['@id' => $webPageId, 'mainEntity' => ['@id' => $mainId]]);
        }

        SchemaRegistry::addAll($entities);
    }

    protected function registerSubject(DataObject $subject, string $url, array $breadcrumbs): void
    {
        SchemaRegistry::add(SchemaBuilder::webPage($subject, $url, $breadcrumbs));
        if ($breadcrumbs) {
            SchemaRegistry::add(SchemaBuilder::breadcrumbList($url, $breadcrumbs));
        }
    }

    protected function pageBreadcrumbs(DataObject $page): array
    {
        $breadcrumbs = [];
        if (!$page->hasMethod('getBreadcrumbItems')) {
            return $breadcrumbs;
        }

        foreach ($page->getBreadcrumbItems() as $item) {
            if ($item instanceof RedirectorPage) {
                continue;
            }
            $breadcrumbs[] = ['name' => (string) ($item->MenuTitle ?: $item->Title), 'url' => $item->AbsoluteLink()];
        }

        return $breadcrumbs;
    }

    protected function registerElements(DataObject $page): void
    {
        if (!$page->hasMethod('ElementalArea')) {
            return;
        }

        $area = $page->ElementalArea();
        if (!$area || !$area->exists()) {
            return;
        }

        foreach ($area->Elements() as $element) {
            if ($element->hasMethod('LinkedElement') && $element->LinkedElement()?->exists()) {
                $element = $element->LinkedElement();
            }
            $this->registerProvided($element);
        }
    }

    protected function registerProvided(DataObject $object): void
    {
        if ($object->hasMethod('provideSchemaEntities')) {
            SchemaRegistry::addAll($object->provideSchemaEntities() ?: []);
        }
    }
}
