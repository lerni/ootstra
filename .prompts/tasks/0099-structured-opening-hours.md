# Task: Structured opening hours (OpeningHour model + schema.org OpeningHoursSpecification)

Status: active

## Context & Goal
`Location.OpeningHours` was a free `Text` field, split by line and passed to schema.org `openingHours`.
Free text is not valid there, and `Vacation` never reached the schema output.
Google Places API is no option for vacations: `currentOpeningHours.specialDays` only covers ~7-10 days ahead.
Business Information API (`specialHours`) needs OAuth + API approval per customer -> out of scope for now.

Goal: the CMS is the single source of truth for regular hours and closures, emitted as valid
`OpeningHoursSpecification` and usable on the frontend.

## Decisions
- New `App\Models\OpeningHour` (has_one `SiteConfig`, relation `SiteConfig.OpeningHours`):
  `DayFrom`, optional `DayTo` (range), `Opens`, `Closes` (Time), `Note`, `Sort`.
  Lunch break = two rows; row without times = "closed" (shown on frontend, omitted from schema).
- Hours and `Vacation` are site-wide (synced from sigi), edited in the SiteConfig tab "Opening hours & Vacations"
  via `GridFieldEditableColumns` + orderable rows. `Vacation` has no location relation.
- `SiteConfig::OpeningHoursSpecifications()` = regular ranges + one closure per current/upcoming `Vacation`
  (`opens=closes=00:00`, `validFrom`/`validThrough`, no `dayOfWeek`). Closures are only emitted when regular hours exist.
- `SchemaBuilder::organization()` emits `openingHoursSpecification()` on the Organization, only for `LocalBusiness`
  schema types (`SchemaBuilder::supportsOpeningHours()`); the SiteConfig tab shows a notice about that.
- `SiteConfig::OpeningHoursHTML()` renders escaped lines; shortcode `[OpeningHours Days="cccc"]`.
  `[Location ... Field="OpeningHours"]` forwards to it (legacy). Location shortcodes also accept `ID="..."`
  (plus a read-only shortcode block in the Location CMS form); numeric `Title="1"` still works.
- **No data migration.** The legacy `Location.OpeningHours` text column and the `OpeningHour.LocationID` /
  `Vacation_Locations` leftovers stay orphaned in the DB.

## Out of scope / later
- Push to Google Business Profile (opt-in per project, OAuth).
- "By appointment" ranges.
- Per-location opening hours (dropped with the SiteConfig model).

## System Constraints
- Follow conventions in `AGENTS.md` and `.prompts/system/silverstripe-conventions.md`
- i18n via `_t()`, German only in `app/lang/de_CH.yml`

## Execution Log
- Agent: GitHub Copilot (Claude)
- Verified via a throwaway transaction script: schema JSON output, HTML lines, validation; db:build created `OpeningHour`.
- Ported the SiteConfig-wide model from sigi; fixtures (hours, vacation, `[OpeningHours]`/`[Vacation]` in Kontakt) and footer added.
- Result Commit(s): _pending_
