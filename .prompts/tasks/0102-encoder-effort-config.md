# Task: JXL encoder effort — config knob vs. upstream default

Status: active

## Context & Goal
While looking at JXL it turned out that libvips' savers take a second knob besides `Q`: `effort`
(CPU vs. bytes). Initial question: should `lerni/silverstripe-assets-intervention4` offer a config
default for it, and should `.Convert()` become parameterisable (`.Convert('avif', 60, 6)`)?

### Why Intervention 4 can't do it today (the surprising part)
- The generic encoders (`AvifEncoder`, `JxlEncoder`, `WebpEncoder`) only take `quality` and `strip`;
  `Format::encoder()` filters options by constructor parameter name, so `effort` is silently dropped.
- The manager `Config` set via `ImageManagerFactory` is a closed set (`autoOrientation`,
  `decodeAnimation`, `backgroundColor`, `strip`); `Config::setOptions()` throws for anything else.
  There is **no driver-level hook for encoder defaults** — the driver only swaps the encoder class by
  namespace convention (`AbstractDriver::specialize()`, private, keyed on `$this::class`'s namespace,
  so a driver subclass in another namespace breaks resolution for *all* modifiers/encoders).
- The vips driver (4.2.0) hard-codes `effort` 1 for AVIF/HEIC and 2 for WebP
  ([image-driver-vips#113](https://github.com/Intervention/image-driver-vips/pull/113), nlemoine,
  2026-05) and sets nothing for JXL → libvips default 7.

### Upstream position (decisive for the approach)
- In #113 nlemoine proposed exactly the obvious fix — `public ?int $effort = null` on the generic
  encoders, driver falls back to its default when null. **Oliver Vogel declined**: "integrating one
  single driver-specific parameter into Intervention Image's public API … wouldn't be aligned with
  the product direction" (unified API, interchangeable drivers).
- He opened [Intervention/image#1491](https://github.com/Intervention/image/issues/1491) "Add more
  encoder options" (bit depth, dither, compression type, filter, effort), label `major-release`,
  no activity/PRs since 2026-05-24. → The knob is considered legitimate, but for Intervention 5.
- nlemoine's reference table in #113: imgproxy defaults AVIF to effort 1 (speed 8), imagor/weserv keep
  libvips' 4; all keep WebP at 4. Nobody in that thread looked at JXL.
- Our comment on #1491 with the JXL data (effort as a codec property, request-time vs. build-time
  needs, nullable `effort` with "null = driver default"):
  https://github.com/Intervention/image/issues/1491#issuecomment-6625817403

### Benchmarks (dev container, arm64, libvips 8.16.1, libjxl 0.11.2)
1600×1200 photo, Q60, `VIPS_CONCURRENCY=1`:

| Format | effort | Bytes | Time |
|---|---|---|---|
| AVIF | 1 (Intervention default) | 259 KB | 52 ms |
| AVIF | 4 (libvips default) | 268 KB | 495 ms |
| AVIF | 9 | 273 KB | 5.3 s |
| JXL | 3 | 202 KB | 23 ms |
| JXL | 4 | 205 KB | 35 ms |
| JXL | 5 | 165 KB | 94 ms |
| JXL | 7 (libvips default) | 169 KB | 429 ms |
| JXL | 9 | 156 KB | 2.3 s |
| WebP | 2 (Intervention default) | 244 KB | 55 ms |
| WebP | 4 (libvips default) | 232 KB | 117 ms |

JXL at Q75 (Intervention default), 1920 px, median of 3, all cores:

| effort | photo 1920×1440 | flat graphic 1393×1920 |
|---|---|---|
| 3 | 353 KB / 34 ms | 83 KB / 26 ms |
| 4 | 358 KB / 44 ms | 86 KB / 33 ms |
| **5** | **316 KB / 133 ms** | **87 KB / 131 ms** |
| 6 | 319 KB / 231 ms | 88 KB / 219 ms |
| 7 | 319 KB / 334 ms | 88 KB / 371 ms |
| 9 | 297 KB / 2.7 s | 80 KB / 2.9 s |

Lossless (Q100): effort 5 vs 7 → +4 % bytes (2.20 vs 2.11 MB photo, 1.23 vs 1.18 MB graphic) at
2.5–2.7× less time.

Through the Silverstripe backend at the project's Q84 (`writeTo()`, 1600 px photo,
`VIPS_CONCURRENCY=1`): effort 4 → 350 KB / 130 ms, 5 → 336 KB / 463–537 ms, 7 → 336 KB / 896 ms.
AVIF default 438 KB / 231 ms, WebP default 400 KB / 66 ms (same source).

Reading: AVIF/WebP upstream defaults are right (more AVIF effort even *grows* files at fixed Q with
aom). For JXL, **5 is the last level that is never larger than 7** and 2.5–4.5× faster; 4 is another
3× faster but +12 % on photos at Q75 (−2 % on the graphic) — a project trade-off, not a default.

### Decisions
1. **No per-call template parameter** (`.Convert('avif', 60, 6)`): four layers would have to change
   (`ImageManipulation::Convert()` in core — trait method, not overridable by an Extension;
   `InterventionImageFileConverter::validateOptions()` only allows `quality`; the `InterventionBackend`
   patch; the Intervention encoders), and the variant name from `manipulateExtension()` contains
   neither quality nor effort, so a template change would serve stale variants.
2. **No config knob for now.** A first iteration (patches `0006` encoder_options in
   `InterventionBackend`, `0007` nullable `effort` on the generic encoders, `0008` vips encoders
   honouring it; verified working end-to-end) was rolled back: `0007` is the approach the maintainer
   explicitly declined, so it would be a *permanent* patch against stated product direction — the
   opposite of this package's goal (a shrinking patch set with upstream paths, cf. 0001/0003).
   Patch-free alternatives (driver subclass → namespace problem above; `SpecializedInterface` encoder
   subclasses in the package + an encoder mapping in `InterventionBackend`) are more surface than a knob
   the project doesn't use yet (no JXL in templates) justifies. Revisit when #1491 lands.
   Explicitly **no `NEXT.md` entry** (user decision) — this spec is the record.
3. **Do what #113 did, for JXL:** a fixed web-tuned default `effort => 5` in the vips `JxlEncoder`,
   shipped as package patch `0006-vips-jxl-effort-default.patch` (`intervention/image-driver-vips`,
   target tag `3.3.1`) and proposed upstream; drop the patch once released. Harmless when the vips
   driver isn't installed (composer-patches only patches on package install events).

## Upstream PR draft (Intervention/image-driver-vips)
Branch suggestion: `perf/jxl-effort-default`. Diff = `patches/0006-vips-jxl-effort-default.patch`
(installed 4.2.0 `JxlEncoder.php` is identical to `main`).

**Title:** perf(encoders): set web-tuned effort default for JXL (effort=5)

**Body:**
> libvips' `jxlsave` defaults to `effort=7`. #113 gave the AVIF/HEIC (1) and WebP (2) encoders
> web-tuned effort defaults, but `JxlEncoder` never sets `effort`, so it still inherits 7 and spends
> 2.5–4.5× the encoder CPU of effort 5 for equal or slightly larger output.
>
> Set `effort=5` for JXL. Measured with libvips 8.16.1 / libjxl 0.11.2 (median of 3):
>
> | effort | 1920×1440 photo, Q75 | 1393×1920 flat graphic, Q75 | 1600×1200 photo, Q60 |
> |---|---|---|---|
> | 3 | 353 KB / 34 ms | 83 KB / 26 ms | 202 KB / 23 ms |
> | 4 | 358 KB / 44 ms | 86 KB / 33 ms | 205 KB / 35 ms |
> | **5** | **316 KB / 133 ms** | **87 KB / 131 ms** | **165 KB / 94 ms** |
> | 7 (libvips default) | 319 KB / 334 ms | 88 KB / 371 ms | 169 KB / 429 ms |
> | 9 | 297 KB / 2.7 s | 80 KB / 2.9 s | 156 KB / 2.3 s |
>
> 5 is the lowest effort whose output is never larger than 7's; 3–4 are another 3× faster but cost
> up to +12 % bytes on photos, so they were not used (same reasoning as not using effort=1 for WebP in
> #113). Lossless (Q100) at effort 5 is +4 % bytes for 2.5× less time.
>
> `jxlsave` has had `effort` since libvips 8.11, so no version gate is needed (range 1..9).

## System Constraints
- Follow conventions in `AGENTS.md` and `.prompts/system/silverstripe-conventions.md`
- No git write operations (commit/push/tag) without explicit permission; no deploy scripts.
- Module patches must use pinned raw URLs + `sha256` (dependency patches can't use local paths).

## Execution Log
- Agent: Copilot
- Found during analysis: `vendor/silverstripe/assets/src/InterventionBackend.php` did not contain
  patch `0004` (`ensureInMemory`) although `patches.lock.json` lists it (file dated 2025-10-31,
  probably a reinstall without repatch). Applied locally with `patch -p1` (same result as
  `composer patches-repatch`).
- Iteration 1 (rolled back, see Decisions 2): `0006` encoder_options + `0007` + `0008`, project
  config `encoder_options.jxl.effort: 4`. Verified via ssshell: unconfigured == explicit effort 7
  (byte-identical), effort 4 → 130 ms vs 896 ms, AVIF/WebP unchanged, `quality` in config ignored,
  unknown options dropped, `Convert('jxl')` wrote the store variant. Reverted from vendor, patch
  files deleted, `app/_config/image.yml` restored.
- Iteration 2 (current): `patches/0006-vips-jxl-effort-default.patch`, `composer.json` entry
  (`intervention/image-driver-vips`, URL pinned to `3.3.1`, sha256), README (patch table + "Encoder
  effort" section with benchmark and upstream context). Applied to vendor; verified via ssshell:
  `writeTo()` JXL 336 058 bytes / 537 ms (was 336 094 / 896 ms at effort 7), `Convert('jxl')` 363 ms,
  AVIF unchanged. No project config needed.
- To finish (needs the user): commit + tag `3.3.1` + push in the package repo, then in the project
  `composer update lerni/silverstripe-assets-intervention4 && composer patches-relock && composer patches-repatch`
  and commit `composer.lock` + `patches.lock.json`. Open the upstream PR from the draft above.
- Result Commit(s): `<sha>`
