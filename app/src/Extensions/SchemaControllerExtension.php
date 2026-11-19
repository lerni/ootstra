<?php

namespace App\Extensions;

use App\Schema\SchemaBuilder;
use App\Schema\SchemaRegistry;
use Spatie\SchemaOrg\BaseType;
use SilverStripe\Core\Extension;
use SilverStripe\ORM\DataObject;
use App\Schema\SchemaIdentifiers;
use SilverStripe\Control\Director;
use SilverStripe\ErrorPage\ErrorPage;
use SilverStripe\CMS\Model\RedirectorPage;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Controllers\ContentController;

/**
 * Collects all schema.org entities of a request into {@see SchemaRegistry}.
 * Emission as a single JSON-LD `@graph` happens in {@see \App\Schema\SchemaResponseMiddleware}.
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
        if ($this->wrapsElement()) {
            return;
        }

        SchemaRegistry::flush();
    }

    public function onAfterInit(): void
    {
        $owner = $this->getOwner();
        $page = $owner->hasMethod('data') ? $owner->data() : null;
        if ($page instanceof ErrorPage || $this->wrapsElement()) {
            return;
        }

        SchemaRegistry::setHookOwner($owner);
        SchemaRegistry::add(SchemaBuilder::organization());
        SchemaRegistry::add(SchemaBuilder::website());

        if (!$page instanceof DataObject || !$page->exists() || !$page->hasMethod('AbsoluteLink')) {
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
     * Elemental inits a controller per element while the page renders (UserDefinedFormController for ElementForm);
     * those must neither flush the registry nor register the element as a page.
     */
    protected function wrapsElement(): bool
    {
        $owner = $this->getOwner();

        return $owner->hasMethod('data') && $owner->data() instanceof BaseElement;
    }

    /**
     * Registers WebPage, BreadcrumbList and contributed entities of a managed item
     * (e.g. Perso) that is rendered below a holder page.
     *
     * @param array<int, array{name: string, url: string}>|null $breadcrumbs Explicit trail, if the item has no getBreadcrumbItems()
     */
    public function registerSchemaForItem(DataObject $item, DataObject $holder, ?array $breadcrumbs = null, ?string $name = null): void
    {
        // Items without AbsoluteLink() (e.g. shop nodes) only know their relative Link()
        $url = $item->hasMethod('AbsoluteLink')
            ? $item->AbsoluteLink()
            : ($item->hasMethod('Link') && $item->Link() ? Director::absoluteURL($item->Link()) : null);
        if (!$url) {
            return;
        }

        // Same trail as the rendered breadcrumbs; fall back to holder + item
        $breadcrumbs ??= $item->hasMethod('getBreadcrumbItems')
            ? $this->pageBreadcrumbs($item)
            : [...$this->pageBreadcrumbs($holder), ['name' => (string) $item->getTitle(), 'url' => $url]];

        $this->registerSubject($item, $url, $breadcrumbs, $name);
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

    protected function registerSubject(DataObject $subject, string $url, array $breadcrumbs, ?string $name = null): void
    {
        SchemaRegistry::add(SchemaBuilder::webPage($subject, $url, $breadcrumbs, $name));
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
            // ArrayData items (e.g. ShopPage) only expose a relative Link
            $url = $item->hasMethod('AbsoluteLink') ? $item->AbsoluteLink() : Director::absoluteURL((string) $item->Link);
            $breadcrumbs[] = ['name' => (string) ($item->MenuTitle ?: $item->Title), 'url' => $url];
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
