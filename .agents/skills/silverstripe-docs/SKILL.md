---
name: silverstripe-docs
description: 'Look up official Silverstripe CMS/Framework developer documentation locally instead of fetching docs.silverstripe.org. Use when answering questions about Silverstripe APIs, DataObjects, ORM, Forms, Extensions/DataExtension, Elemental, templates, configuration YAML, permissions/security, testing, i18n, files/assets, CLI tasks, deployment, or upgrading — or whenever unsure about correct Silverstripe usage/conventions.'
---

# Silverstripe Developer Docs (local)

Full markdown documentation is vendored via `composer require-dev silverstripe/developer-docs`
at `vendor/silverstripe/developer-docs/en/`. Read files directly with `read_file` /
`grep_search` instead of fetching the web docs — it's the same content, constrained to the
same major version as the installed CMS/Framework and works offline.

Each folder has an `index.md` overview. Drill into a topic by reading the matching file/folder.

## Table of Contents

- `00_Getting_Started/` — install, composer, environment (`.env`), directory structure, recipes
- `02_Developer_Guides/`
  - `00_Model/` — DataObjects, ORM, relations, migrations
  - `01_Templates/` — `.ss` templates, template syntax, layouts
  - `02_Controllers/` — routing, controllers, `RequestHandler`
  - `03_Forms/` — `FormField` types, validation, form templates
  - `04_Configuration/` — YAML config, `Injector`, environment vars
  - `05_Extending/` — `Extension`/`DataExtension`, hooks, events
  - `06_Testing/` — `SapphireTest`, fixtures, functional tests
  - `07_Debugging/` — dev mode, debug URL params, error handling
  - `08_Performance/` — caching, partial caching, query optimisation
  - `09_Security/` — permissions, member/group security, CSRF, sanitisation
  - `10_Email/` — `Email` class, templates, admin emails
  - `11_Integration/` — REST/GraphQL, RSS, third-party integration
  - `12_Search/` — search index integration
  - `13_i18n/` — `_t()`, `<%t %>`, translation YAML
  - `14_Files/` — asset storage, `Image`/`File`, manipulations
  - `15_Customising_the_Admin_Interface/` — CMS UI, React/Redux, `ModelAdmin`, GridField
  - `16_Execution_Pipeline/` — request lifecycle, middleware
  - `17_CLI/` — `sake`, CLI tasks
  - `18_Cookies_And_Sessions/`
  - `20_Deprecations/`
- `04_Optional_Features/` — optional/legacy features
- `06_Upgrading/` — upgrading between major versions
- `08_Changelogs/` — per-release changelogs (security fixes, breaking changes)
- `10_Contributing/` — contributing to Silverstripe core
- `12_Project_Governance/`

## Usage

1. Start at `vendor/silverstripe/developer-docs/en/index.md` or the relevant section's `index.md`.
2. Use `grep_search` with `includePattern: 'vendor/silverstripe/developer-docs/en/**'` for keyword lookups across all docs.
3. Only fetch `docs.silverstripe.org` over the web if the topic genuinely isn't covered locally.
