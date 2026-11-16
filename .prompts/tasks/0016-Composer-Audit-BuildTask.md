# Task: Composer Audit BuildTask (CVE + Abandoned/EOL packages)

Status: active

## Context & Goal
Add a `BuildTask` that runs `composer audit` to detect known security
advisories (CVEs) and abandoned/end-of-life packages in this project's
dependencies, and emails a report when findings exist. Should be runnable via
`sake tasks:composer-audit` (CLI/cron) or `/dev/tasks/composer-audit` (HTTP,
admin-gated by core `BuildTask` permissions).

## System Constraints
- Follow conventions in `AGENTS.md` and `.prompts/system/silverstripe-conventions.md`
- New file: `app/src/Tasks/ComposerAuditTask.php`, extends `SilverStripe\Dev\BuildTask`
- Shell out via `Symfony\Component\Process\Process` with array args only (no
  shell string interpolation) — avoids command injection
- Reuse patterns from `app/src/Tasks/TestEmailTask.php`: admin_email fallback
  block, CLI-vs-HTTP `to` resolution, `Email::create()->setBody()->setTo()
  ->setSubject()->send()` wrapped in `try/catch (TransportExceptionInterface
  | Exception)`
- No new YAML config — all knobs are CLI/task options, not persisted config
- Run `php ./vendor/bin/php-cs-fixer fix app/src/Tasks/ComposerAuditTask.php`
  after edits are complete
- i18n: **out of scope for this task** — strings are plain English for now
  (internal/ops tool, English-only recipients); revisit with `_t()` if it ever
  becomes user-facing

## Decisions
- Default audits **production deps only** (`--no-dev`); `--include-dev` flag
  overrides for one-off runs.
- Email **To** = `--to` if given, else `SS_ERROR_EMAIL` env var, falling back
  to `Email::config()->get('admin_email')` (string or array, same fallback
  block as `TestEmailTask`; `app/_config.php` fills `admin_email` from
  `SS_ADMIN_EMAIL`, so that env var is respected indirectly).
  **From** = left to Silverstripe's default admin_email behavior (no explicit
  `setFrom()`, same as `TestEmailTask`).
- `--abandoned=<ignore|report|fail>` task option, passed through to
  `composer audit --abandoned=`, default `report`. Validate against the
  whitelist before use, falling back to `report` on invalid input.
- `--ignore-severity=<value>` task option (repeatable), passed through to
  `composer audit --ignore-severity=`, default none (report all severities).
  Values are lowercased and validated against `low|medium|high|critical`;
  anything else fails the task with an error (no silent fallback).
- `--dry-run` flag: builds/prints the report but skips sending the email.
- `--to` option (CLI) / `?to=` (HTTP): overrides the recipient, validated via
  `Email::is_valid_address()`; an invalid value fails the task (no silent
  fallback to the default recipient).
- Scheduling (OS cron calling `sake tasks:composer-audit`) is **out of
  scope** — no `silverstripe/crontask` module in this repo; to be wired up
  separately (same pattern as the cron comment in `deploy/backup.sh`).
- Task returns `Command::SUCCESS` once the audit ran and (if needed) the
  email was sent — findings are the expected output of a successful run.
  Only returns `Command::FAILURE` if composer couldn't be located/executed
  (incl. process start failure or the 120s timeout), its JSON output wasn't
  parseable, or an option value is invalid.
- No-findings output is just `No findings.` — what counts as a finding
  depends on the options (`--no-dev`, `--abandoned=ignore`,
  `--ignore-severity`), so the message makes no claim about package classes.
- Report host (email subject/header) comes from `Director::absoluteBaseURL()`.
  Core falls back to `SS_BASE_URL`, then `SERVER_NAME`, then `gethostname()`,
  so it is never empty; under cron without `SS_BASE_URL` it shows the server
  hostname over `http://`. Set `SS_BASE_URL` in `.env` on test/live for a
  proper domain. No custom fallback.
- `is_enabled` toggle already works out of the box via core `BuildTask`
  config (see `app/_config/disabled_tasks.yml` pattern) — no new config
  needed for that.

## Implementation Steps
1. Create `app/src/Tasks/ComposerAuditTask.php`:
   - `resolveComposerBinary()`: try `which composer` (validate
     non-empty + `is_executable()`), else fall back to
     `$HOME/bin/composer.phar` (existing production convention per
     `deploy/config.php` / `deploy/recipe/silverstripe.php`), invoked via
     `[PHP_BINARY, $phar]`. Returns `null` if neither resolves.
   - `getOptions()`: `to`, `dry-run`, `include-dev`, `abandoned`,
     `ignore-severity` (repeatable).
   - `execute()`: build args (`audit --format=json --no-interaction
     [--no-dev] --abandoned=<mode> [--ignore-severity=<sev> ...]`), run via
     `Process` with `cwd = BASE_PATH`, parse JSON from stdout regardless of
     process exit code (composer exits 1 merely because issues were found —
     expected, not a task failure). Count advisories/abandoned packages,
     build an HTML report (plain `<br>`-joined body, same style as
     `TestEmailTask`), resolve recipient, then either print (`--dry-run`) or
     send the email.
2. Format: `php ./vendor/bin/php-cs-fixer fix app/src/Tasks/ComposerAuditTask.php`.
3. Validate with `get_errors` on the new file.

## Verification
1. `get_errors` on the new file.
2. `php ./vendor/bin/sake tasks:composer-audit --dry-run` — confirm it
   resolves `composer`, runs the audit, prints a parsed report (or "No
   findings.") without sending mail.
3. `php ./vendor/bin/sake tasks:composer-audit --to=<test-address>` (or
   check Mailpit) — confirm an email arrives only if findings exist.
4. Confirm `--abandoned=ignore` and `--ignore-severity=<level>` filter the
   report correctly; invalid `--to` / `--ignore-severity` values fail with
   an error.
5. Code review for the composer-not-found fallback path (hard to simulate
   live in the devcontainer where composer is on PATH).
6. Re-run `php-cs-fixer` + `get_errors` after any later edits.

## Further Considerations
1. Composer audit's exact JSON field names (`cve`, `title`, `severity`,
   `link` on advisories; string-or-null on abandoned entries) should be
   confirmed against a live `composer audit --format=json` run against this
   repo and accessed defensively (`?? null` / `?? 'n/a'`).
2. No dedup for repeated findings across runs — acceptable for now per
   "keep it simple", but could track last-reported state later if the email
   volume becomes noisy.

## Execution Log
- Agent: Claude Sonnet 5 (GitHub Copilot)
- Verified locally (2026-11-14): `--dry-run` (1 abandoned: behat/transliterator,
  no mail), `--include-dev --dry-run`, `--abandoned=ignore` ("No findings.",
  no mail), default run (mail delivered to Mailpit, exactly 1 message),
  invalid `--to` and `--ignore-severity` fail with an error.
- Not verified: advisory fields (`cve`/`severity`/`link`; none present in this
  repo), composer.phar fallback path, process timeout path, HTTP `?to=`.
- Result Commit(s): `<sha>`
