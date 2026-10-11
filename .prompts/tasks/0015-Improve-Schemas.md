    # Task: Improve schema.org / JSON-LD output (registry + bug fixes)

    Status: active

    ## Context & Goal
    We use `spatie/schema-org` in a few places via extensions (`PageSchemaExtension`,
    `UrlifyExtension`, `Perso::PersoSchema()`, `ElementContentSection::FAQSchema()`),
    each returning `->toScript()` and output ad-hoc via `$XSchema.RAW` in specific
    `.ss` templates. This was compared against Tim's (DorsetDigital)
    `silverstripe-schema-manager` module, vendored for review at `/var/www/html/tim-schema`.

    Full comparison/analysis is in chat history (2026-09-20 session). Summary:
    our per-model `spatie` extensions are the right building blocks (typed,
    reuse existing CMS fields, no redundant data entry) but we lack a central
    registry, so entities aren't linked/deduped and are emitted as N independent
    `<script>` blocks instead of one linked `@graph`. Tim's module gets the
    registry/linking right but reintroduces redundant CMS fields (a whole
    parallel `SchemaOrganisation*` tab on SiteConfig duplicating Location/
    SocialLinks/DefaultHeaderSlides data) — we should NOT copy that part.

    Goal: fix the concrete bugs below, then add a lightweight request-scoped
    registry so all schema output merges into a single, correctly cross-linked
    `@graph` JSON-LD block, emitted automatically without needing to remember
    `$X.RAW` placement per template.

    ## Findings / Bugs to fix

    1. **Dangling `@id` reference**: `Perso::PersoSchema()` always sets
    `worksFor → {@id: .../#organization}`, but `$OrganisationSchema.RAW` is only
    ever rendered `<% if $isHomePage %>` in [themes/default/templates/Page.ss](../../themes/default/templates/Page.ss).
    On any non-home page (e.g. any Perso page), the referenced Organization
    node was never actually output on that page.
    2. **`@id` mismatch risk**: [app/src/Extensions/PageSchemaExtension.php](../../app/src/Extensions/PageSchemaExtension.php)
    builds the org id as `Director::absoluteBaseURL() . '/#organization'`
    (extra `/`), while `Perso.php` builds it as
    `Director::absoluteBaseURL() . '#organization'` (no `/`). Since
    `absoluteBaseURL()` already ends in `/`, these can produce different
    strings and silently break the `worksFor` link.
    3. **Duplicate code, only one half live**: `BreadcrumbListSchema()` exists in
    both `PageSchemaExtension` and `UrlifyExtension` with near-identical logic.
    `PageSchemaExtension`'s copy is called — [themes/default/templates/Page.ss](../../themes/default/templates/Page.ss)
    renders `$BreadcrumbListSchema.RAW` unconditionally, and `PageSchemaExtension`
    is applied to `Page`, so it runs on every page request. `UrlifyExtension`'s
    copy (applied only to `App\Models\Perso`) is the actually-dead one — no
    template renders `$BreadcrumbListSchema.RAW` in a `Perso`/
    `SlugHolderPage_Perso` context, so that duplicate never executes.
    4. **No `WebPage`/`WebSite` schema** exists at all currently, despite being
    the standard baseline (`Organization → WebSite → WebPage → BreadcrumbList`)
    that Google's own examples build on, and being derivable purely from data
    we already have (`Title`, `MetaDescription`/`DefaultMetaDescription`,
    `Created`, `LastEdited`, `AbsoluteLink()`).
    5. Organisation schema is currently home-only; it's referenced from other
    pages (Perso) so should be emitted site-wide (or the reference should be
    conditional on actually being present).

    ## Plan

    1. **Central `@id` helper** — one small class/trait (e.g.
    `App\Schema\SchemaIdentifiers` or static methods) providing
    `organizationId()`, `websiteId()`, `webPageId(SiteTree $page)` so every
    extension/model agrees on the exact string (no `rtrim`/slash drift).
    2. **Request-scoped registry** — small static class (similar shape to
    `tim-schema`'s `SchemaRegistry`, but our own, no new dependency):
    - `add(string $id, array $data)` merging via `array_replace_recursive`
    - `getGraph(): array`, `getJSON(): string`
    - `flush()` reset at request start
    Keep using **spatie/schema-org** to build entities (`->toArray()` or
    `->jsonSerialize()`), just push them into the registry instead of calling
    `->toScript()` inline in templates. Do not adopt Tim's hand-rolled
    `Schema` value classes — spatie already covers the full schema.org
    vocabulary.
    3. **Single output point** — a `Requirements_Backend` subclass (or simpler:
    a `ContentController`/`onAfterInit` extension calling
    `Requirements::insertHeadTags()` once) that emits exactly one
    `<script type="application/ld+json">` with `@context` + `@graph` from the
    registry. Remove the per-template `$X.RAW` calls in `Page.ss`,
    `ElementContentSection.ss`, `SlugHolderPage_Perso.ss` — replace with
    registry registration inside the existing extension methods
    (`OrganisationSchema()`, `PersoSchema()`, `FAQSchema()`), fired from
    `onAfterInit`/`onBeforeRender` so contribution still happens near the
    code that owns the data, but emission is centralized.
    4. **Emit Organisation + new WebPage/WebSite schema on every page**
    automatically (via one extension on `ContentController`), fixing bug #1
    and #5. Do **not** add new SiteConfig fields for this — keep reusing
    `Title`, `legalName`, `MetaDescription`, `Locations`, `SocialLinks`,
    `DefaultHeaderSlides` as `PageSchemaExtension` already does.
    5. **Dedupe `BreadcrumbListSchema()`** into one shared implementation, wire
    it into the registry (currently dead code) so breadcrumbs actually ship.
    6. **Optional**: add an `updateSchemaEntities(array &$entities)` (or similar)
    extension hook so future elements/modules can contribute without
    modifying core files — mirrors `tim-schema`'s `updateSchemaManagerEntities`
    hook, which is a clean pattern worth borrowing.
    7. Validate output with Google's Rich Results Test / Schema.org validator on
    a page with Perso + FAQ + breadcrumbs to confirm the merged graph resolves
    all `@id` references correctly.
    8. Once merged and validated, decide whether to keep `/var/www/html/tim-schema`
    vendored for reference or remove it (it's not a composer dependency).

    ## System Constraints
    - Follow conventions in `AGENTS.md` and existing `_config`/i18n patterns.
    - Keep `spatie/schema-org` as the schema-building library; no new schema.org
    dependency.
    - No new redundant CMS fields — reuse existing Location/SocialLinks/SiteConfig
    data as the current `PageSchemaExtension` already does.
    - Run `php ./vendor/bin/php-cs-fixer fix <file>` on every modified PHP file.

    ## Execution Log
    - Agent: GitHub Copilot (Claude Sonnet 4.5), analysis session 2026-09-20
    - Implemented 2026-10-09 (Copilot): `App\Schema\{SchemaIdentifiers,SchemaRegistry,SchemaBuilder,SchemaRequirementsBackend}`,
  `App\Extensions\SchemaControllerExtension` (on `ContentController`), `Requirements_Backend` swapped via Injector in `mysite.yml`.
  Contributors implement `provideSchemaEntities(): array` (`Perso`, `ElementContentSection`); `updateSchemaGraph(array &$graph)` hook on the current controller.
  `Page.ss`/`ElementContentSection.ss`/`SlugHolderPage_Perso.ss` no longer emit schema; `UrlifyExtension::BreadcrumbListSchema()` removed.
  `PageSchemaExtension` is now a static facade (still used by `lerni/jobpostings`), no longer a Page extension.
  Verified: home + Perso detail emit one `@graph` with resolving `@id`s. FAQ path only smoke-tested (no FAQ data locally).
- 2026-10-09 (Copilot): `JobPosting` (vendor/lerni/jobpostings) now implements `provideSchemaEntities()` (+ `buildJobPostingSchema()`; `JobPostingSchema()` kept for BC); `$JobPostingSchema.RAW` removed from the package and theme templates. Breadcrumbs: `UrlifyExtension::getBreadcrumbItems()` is the single source for the HTML trail and the schema BreadcrumbList; `SlugHolderPage_Perso.ss` renders `{$Breadcrumbs}` inside `<% with $CurrentItem %>` (was holder-only before).
- Open (vendor change needs commit/release in `kraftausdruck/jobpostings`). Step 7 (Rich Results Test) and 8 (tim-schema removal) pending.
- 2026-10-10 (Copilot): BlogPost → `og:type=article` via native `Page::getOGType()` (beats extension method order) + `article:*` getters on `BlogPostExtension` (fork's `OGArticle` builder calls all six). `BlogPostExtension::provideSchemaEntities()` emits `BlogPosting` (`#article`; author/publisher → `#organization`, no person authors). `SchemaControllerExtension` now also asks the page itself for entities; WebPage `datePublished` prefers `PublishDate`. Twitter card stays off (X falls back to OG). Blog holder `CollectionPage` not done.
- 2026-10-10 (Copilot): `JobPosting` (vendor/lerni/jobpostings) `hiringOrganization` is now a bare `{"@id": #organization}` reference (full node lives once in the graph); standalone `JobPostingSchema()` removed. `PageSchemaExtension` facade has no callers anymore.
