# Task: silverstripe/assets on Intervention Image 4.4 (patch module)

Status: active

## Context & Goal
`silverstripe/assets` 3.2.2 hard-requires `intervention/image ^3.9` (installed 3.11.10, `intervention/gif` 4.2.4).
Run it on Intervention **4.4.0** (needs PHP ^8.3 + `intervention/gif ^5`; env is PHP 8.5) without waiting for upstream,
delivered as a small reusable Composer package that carries the patches.

### Decisions
- Delivery: **cweagans/composer-patches ^2**, upstream `silverstripe/silverstripe-assets` stays the base (no fork).
- Scope: port + low-risk wins. Base = the author's own upstream PR (commits `e0d93ec`, `5f11cc6`: read image from stream, no temp file; 3.x only, expected in assets 3.4 / Silverstripe 6.4).
- **Patch module name (proposal): `lerni/silverstripe-assets-intervention4`**
  - Follows the existing `lerni/silverstripe-*` naming (`-tracking`, `-webmanifest`, `-google-indexing`); "assets" first so it sorts and reads as "assets patched for intervention 4".
  - Alternative from the discussion: `lerni/intervention4-assets` (shorter, but breaks the prefix convention). Renaming is a one-line change in the module's `composer.json` + root `require`; decide before the repo is created.
  - Composer `type: library` (NOT `silverstripe-vendormodule`; it ships no `_config`, so it must not enter the Silverstripe manifest).
  - Branches/tags follow the assets minor it patches: branch `3.2` → tags `3.2.x`; later `3.4` (without patch 0001).

### Module layout (`lerni/silverstripe-assets-intervention4`)
```
composer.json         require: php ^8.3, cweagans/composer-patches ^2, silverstripe/assets ~3.2.0 (loud conflict when assets moves)
                      extra.patches: { "silverstripe/assets": [ {description, url, sha256}, ... ] }
patches/
  0001-stream-read-no-tempfile.patch      (user PR e0d93ec + 5f11cc6; drop once assets >= 3.4)
  0002-intervention-image-4.patch         (the v4 port: src + tests + assets composer.json constraint)
README.md             what/why, how to remove, upstream PR links
```
**Key constraint (verified in composer-patches docs):** patches defined by a *dependency* must use **public URLs**, not local paths
(paths are always resolved relative to the project root, never the dependency). So module `extra.patches` points at
`https://raw.githubusercontent.com/lerni/silverstripe-assets-intervention4/<tag>/patches/....patch` with a pinned `sha256`.
Fallback if URL-in-dependency is troublesome: root `extra.patches` with local path `vendor/lerni/silverstripe-assets-intervention4/patches/...` (needs verification that the package is installed before patching) or a copy in the project `patches/` dir.
Until the repo is published, develop with the root `repositories` entry `{ "type": "path", "url": "../silverstripe-assets-intervention4" }` (or temp vcs) and root-local patch paths.

### Root `composer.json` changes (as implemented)
- `config.allow-plugins`: `"cweagans/composer-patches": true`
- `repositories`: `path` entry `packages/silverstripe-assets-intervention4` (later: vcs entry for the published repo)
- `require`: `"lerni/silverstripe-assets-intervention4": "*@dev"` (later `~3.2.0`). **No alias**: the inline alias `4.4.0 as 3.11.99` does not resolve (tested). The module `provide`s `intervention/image 3.11.99` instead, which satisfies assets' `^3.9` while the real 4.4.0 is installed. A patched `composer.json` in vendor is NOT re-read by the resolver, hence the `provide`.
- Commit `patches.lock.json` alongside `composer.lock`. Patches must ship with deploys (composer install on server; no deployer script changes).

## Analysis: Intervention 3 → 4 changes that matter for assets
Sources: official v3→v4 upgrade guide, 4.4.0 source, releases page.

| Area | v3 (current) | v4 (needed) |
|---|---|---|
| `InterventionManagerFactory`, app `ImageManagerFactory` | `ImageManager::withDriver($d, ...$p)` | `new ImageManager($d, ...$p)` (`usingDriver()` returns the interface type) |
| Driver access (backend x2, converter x2, `GDImageTest`, `ImagickImageTest`) | `$manager->driver()` | public property `$manager->driver` |
| Decoding (`getImageResource`, `loadFrom`) | `read($stream\|$path)` | `decodeStream()` (resource; 4.4 also PSR-7) / `decodePath()` |
| Encoding (`writeToStore`) | `encodeByExtension($e, quality: q)` | `encodeUsingFileExtension($e, quality: q)` |
| `writeTo` | `save($path, $quality)` positional | **`save($path, quality: $q)`** – v4 filters options by name, positional is silently dropped |
| `paddedResize` colours | `Rgb\Color::create('FFFFFF')`, int alpha 0–255 | `Color::parse($hex)`; alpha float 0–1 → `withTransparency()` (cover with a test) |
| Exceptions | `DecoderException`, `EncoderException` | new tree under `ImageException`→`RuntimeException`→`DriverException`; unknown/unsupported encoder ext → `NotSupportedException` (a `LogicException`!); `FilesystemException` for missing/unreadable files. Catch accordingly in `writeToStore`/`writeTo` (keep `[]`/`false`), classify in `getImageResource`/`loadFrom` (`ImageDecoderException`→INVALID, `FilesystemException`→MISSING, else UNKNOWN) |
| Manager config (`image.yml`) | `autoOrientation: true` | still valid; v4 `Config::prepareOptions()` unwraps a single array arg → app-level factory workaround may become unnecessary (verify) |

Unchanged: `scale`, `scaleDown`, `resize`, `contain`, `cover`, `crop` (positional compatible), string alignments (`'top-left'`, `'center'`), `removeAnimation`, `isAnimated`, `width/height`, `AbstractEncoder::DEFAULT_QUALITY`, `driver->config()->decodeAnimation`, `driver->supports('avif')`.
Not used by assets: `pickColor→colorAt`, `pad→containDown`, `place→insert`, `flop`, `greyscale`, `rotate` direction, `toJpeg()` etc.
Collateral: `jonom/focuspoint` *tests* use `pickColor()` (rename to `colorAt()`; test-only, note upstream). `app/src/Utility/ImageManagerFactory.php` uses `withDriver` – must change in the same commit as the vendor bump.
EXIF/orientation with the stream loader is safe in v4 (Imagick `StreamImageDecoder`→`BinaryImageDecoder` extracts EXIF for JPEG/TIFF); existing tests `testAutoOrientateOnEXIFData`, `testExifOrientationOnManipulatedImage` cover it.

## Opportunities
In this patch: named `quality:`, wider exception handling + finer failure classification, Imagick fixes (4.4.0 crop resolution unit), stream/PSR-7 decoding.
Later (not planned, dropped from `NEXT.md`): `strip` option (privacy/size), palette API (`colors()->dominant()`), JXL/HEIC/ICO formats via `supports()`, `containDown`/`coverDown` (needs new `Image_Backend` API), libvips driver `intervention/image-driver-vips` (FFI + system libvips; spike for `ResizeOversizedImagesTask`).

## Risks
- Long-lived patch; assets 3.3/3.4 may conflict → composer-patches fails loudly (desired; `~3.2.0` constraint makes it explicit).
- Output differences (quality mapping, PNG/AVIF/WebP, EXIF orientation, animated GIF/WebP, CMYK, transparency) → compare variants 3.11 vs 4.4.
- Raw upstream commit diffs may not apply to the 3.2.2 tag → derive 0001 with `git diff` of the touched file.
- Dev clone in `vendor/silverstripe/assets` is a source install: export patches from it, then reinstall from dist to verify.

## Todos (tracked in session SQL)
1. `baseline-tests` – assets + focuspoint tests and sample variants on 3.11.10.
2. `create-patch-module` – create repo/dir `lerni/silverstripe-assets-intervention4` (composer.json, README, patches/).
3. `composer-patches-setup` – root allow-plugins, repositories, alias override, dry-run.
4. `patch-0001-stream` – patch from the user's upstream commits.
5. `port-assets-v4` – port in the vendor clone (branch) + tests.
6. `app-factory-update` – `app/src/Utility/ImageManagerFactory.php`.
7. `export-patch-0002` – export, reinstall from dist, verify patches apply cleanly (+ `patches.lock.json`).
8. `verify-and-compare` – tests (GD + Imagick), `db:build`, manual CMS checks, 3.11 vs 4.4 comparison.
9. `docs-and-followups` – finish spec, `NEXT.md` entries; present diff, no commit without permission.

## System Constraints
- Follow conventions in `AGENTS.md` and `.prompts/system/silverstripe-conventions.md`
- No git write operations (commit/push/tag) without explicit permission; no deploy scripts.
- Run `php-cs-fixer` on edited project PHP files (not on vendor/patch files).

## Execution Log
- Agent: Copilot
- Module (decided): **`lerni/silverstripe-assets-intervention4`**, cweagans/composer-patches ^2. Lives in `packages/silverstripe-assets-intervention4/` (path repository) until published as its own repo; see its README.
- **Deviation from plan:** root alias `intervention/image 4.4.0 as 3.11.99` does NOT work (Composer ignores inline aliases on tagged releases). The module instead `provide`s `intervention/image: 3.11.99`; the root only requires the module (`*@dev`) + `allow-plugins` entry + path repository.
- **Deviation from plan:** dist archive of silverstripe/assets has no `tests/`, so a Composer patch can't touch tests. Patches split: `0001` (stream, upstream commits), `0002` (v4 port: src + composer.json), `upstream/0003` (tests, not applied; for upstream PR).
- Dependency patches (module `extra.patches`) work with project-relative paths in dev; before publishing switch to pinned raw URLs + `sha256` (documented in README).
- Done: baseline (v3.11.10): GD 28, Imagick 28, Conversion 20, ImageManipulation 43 tests green. On v4.4.0: GD/Imagick 32 each (4 new tests), Conversion 20, ImageManipulation 43 green, also on a clean `composer patches-repatch` install. Full assets suite: identical 6 failures + 17 errors on v3 baseline and v4 (project-environment related, unrelated to Intervention). FocusPoint: 2 errors (`pickColor()` -> `colorAt()`), test-suite only.
- Done: `app/src/Utility/ImageManagerFactory.php` (`new ImageManager`), real assets via ssshell with Imagick (Scale/Fill/Pad/AVIF convert), front page 200.
- Mutation check confirmed v4 silently drops positional `quality` (new test `testWriteToAppliesQuality` fails without `quality:`).
- Module published (`lerni/silverstripe-assets-intervention4` 3.2.2 via vcs repository, patches 0001-0004 applied in the project).
- **Switched the project to libvips** (`intervention/image-driver-vips` ^4.2 + `jcupitt/vips`): `app/_config/image.yml` (own block `app-image-backend`, `After: '#assetsimage', '#assetsimage-imagick'`) sets `InterventionImageDriver` to `Intervention\Image\Drivers\Vips\Driver`, so the conditional imagick block can't win and `mysite.yml` stays untouched. Verified with `db:build --flush`: Scale/Fill/Pad, chained `ScaleMaxHeight()->Convert('webp')`, AVIF convert, EXIF orientation (landscape-to-portrait 450x600), animated GIF kept, padded alpha, `writeTo()` quality; image test base (34 tests) green on Vips (temporary test class), GD and Imagick; Conversion (20) and ImageManipulation (43) green. Requirements: `ext-ffi` (`ffi.enable`), system `libvips42` (both already in `.ddev`); test/live servers need the same.
- Fixed a corrupt hunk header in the module's `patches/upstream/tests-intervention-image-4.patch` (+110 -> +109) so it applies; not yet committed in the module repo.
- Not done / open: manual CMS checks (upload through the asset admin, CMYK); visual/size comparison 3.11/Imagick vs 4.4/vips; test/live must have libvips + FFI before deploying. Remaining ideas are listed under "Opportunities" above. Nothing committed.
- Result Commit(s): `<sha>`
