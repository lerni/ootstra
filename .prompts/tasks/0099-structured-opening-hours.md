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
- New `App\Models\OpeningHour` (has_one `Location`, relation `Location.OpeningTimes`, cascade delete):
  `DayFrom`, optional `DayTo` (range), `Opens`, `Closes` (Time), `Note`, `Sort`.
  Lunch break = two rows; row without times = "closed" (shown on frontend, omitted from schema).
- Edited inline in the Location via `GridFieldEditableColumns` + orderable rows.
- `Location::OpeningHoursSpecifications()` = regular ranges + one closure per current/upcoming `Vacation`
  (`opens=closes=00:00`, `validFrom`/`validThrough`, no `dayOfWeek`). Closures are only emitted when regular hours exist.
- `SchemaBuilder` uses `openingHoursSpecification()` instead of `openingHours()`.
- `Location::OpeningHoursHTML()` renders escaped lines; shortcode `[Location Title=".." Field="OpeningHours"]`
  returns them when structured hours exist, otherwise falls back to the legacy text.
- **No data migration.** The legacy `OpeningHours` Text column stays (existing shortcode content keeps working),
  is only shown in the CMS when non-empty, labelled legacy and never used for schema.

## Out of scope / later
- Push to Google Business Profile (opt-in per project, OAuth).
- Midnight-crossing ranges (closes after 00:00), "by appointment" ranges.
- Dropping the legacy column once all sites are converted.

## System Constraints
- Follow conventions in `AGENTS.md` and `.prompts/system/silverstripe-conventions.md`
- i18n via `_t()`, German only in `app/lang/de_CH.yml`

## Execution Log
- Agent: GitHub Copilot (Claude)
- Verified via a throwaway transaction script: schema JSON output, HTML lines, validation; db:build created `OpeningHour`.
- Result Commit(s): _pending_
