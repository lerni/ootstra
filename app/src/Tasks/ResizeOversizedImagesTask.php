<?php

namespace Bummzack\Tasks;

use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\Config\Config;
use Axllent\ScaledUploads\ScaledUploads;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\PolyExecution\PolyOutput;
use SilverStripe\Assets\Storage\AssetStore;
use JonoM\FocusPoint\FieldType\DBFocusPoint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use SilverStripe\Assets\Flysystem\FlysystemAssetStore;

/**
 * Resize all source images that exceed the configured ScaledUploads limits.
 * Reads max_width / max_height from Axllent\ScaledUploads\ScaledUploads config.
 *
 * Run via: php ./vendor/bin/sake tasks:resize-oversized-images
 * Imagick's pixel-cache resource accounting isn't reliably released within a single long-running
 * process even with gc_collect_cycles() (see memory-leak-batch-image-cache.md) - on hosts where
 * that causes widespread "cache resources exhausted" failures, use --limit to process a bounded
 * batch per invocation and re-run the (idempotent) task repeatedly, letting each fresh process
 * start with a clean Imagick resource pool.
 */
class ResizeOversizedImagesTask extends BuildTask
{
    protected static string $commandName = 'resize-oversized-images';

    protected string $title = 'Resize oversized source images';

    protected static string $description = 'Scales down source images that exceed the ScaledUploads max_width / max_height config values.';

    public function getOptions(): array
    {
        return [
            new InputOption('limit', null, InputOption::VALUE_REQUIRED, 'Stop after attempting to resize this many images (0 = no limit)', 0),
        ];
    }

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $maxWidth = (int) Config::inst()->get(ScaledUploads::class, 'max_width');
        $maxHeight = (int) Config::inst()->get(ScaledUploads::class, 'max_height');

        if (!$maxWidth && !$maxHeight) {
            $output->writeln('No max_width or max_height configured — nothing to do.');

            return Command::SUCCESS;
        }

        $output->writeln(sprintf('Max dimensions: %dpx × %dpx', $maxWidth, $maxHeight));

        // Only process source files — variants have a non-null FileVariant
        $images = Image::get()->filter(['FileVariant' => null]);
        $total = $images->count();

        $output->writeln(sprintf('Checking %d source images…', $total));

        $limit = max(0, (int) $input->getOption('limit'));
        $attempted = 0;
        $resized = 0;
        $skipped = 0;
        $failed = 0;
        $errors = 0;
        $hasFocusPoint = class_exists(DBFocusPoint::class);

        foreach ($images as $image) {
            if ($limit && $attempted >= $limit) {
                $output->writeln(sprintf('Reached --limit=%d, stopping.', $limit));

                break;
            }

            // Use getimagesize() (no Imagick decode) for the cheap initial check. Calling
            // getWidth()/getHeight() here instead would decode every one of the (thousands of)
            // source images via Imagick in this single long-running process; the native memory
            // this uses isn't released and eventually causes dimension reads to silently fail
            // (0x0) rather than throw - see memory-leak-batch-image-cache.md.
            if ($hasFocusPoint) {
                $width = $image->FocusPoint->getWidth();
                $height = $image->FocusPoint->getHeight();
            } else {
                $dimensions = @getimagesizefromstring($image->getString());
                $width = $dimensions[0] ?? 0;
                $height = $dimensions[1] ?? 0;
            }

            if (!$width || !$height) {
                ++$skipped;

                continue;
            }

            $needsResize = ($maxWidth && $width > $maxWidth) || ($maxHeight && $height > $maxHeight);

            if (!$needsResize) {
                ++$skipped;

                continue;
            }

            // Imagick's pixel-cache resources accumulate across sequential decodes and aren't
            // released until PHP's cyclic GC runs, eventually exhausting policy limits and
            // causing the actual resize below to silently no-op - retry once after a collection
            // before giving up, mirroring ImportFloorLayoutsTask::importImage().
            $ok = false;

            try {
                ++$attempted;

                for ($attempt = 1; $attempt <= 2 && !$ok; ++$attempt) {
                    gc_collect_cycles();
                    $ok = $this->resizeImage($image, $maxWidth, $maxHeight);
                }

                if ($ok) {
                    $output->writeln(sprintf(
                        '  Resized: %s (%dx%d)',
                        $image->FileFilename,
                        $width,
                        $height,
                    ));
                    ++$resized;
                } else {
                    $output->writeln(sprintf(
                        '  FAILED: %s (%dx%d) — image resource unavailable after retry',
                        $image->FileFilename,
                        $width,
                        $height,
                    ));
                    ++$failed;
                }
            } catch (\Throwable $e) {
                $output->writeln(sprintf(
                    '  ERROR: %s — %s',
                    $image->FileFilename,
                    $e->getMessage(),
                ));
                ++$errors;
            }
        }

        $output->writeln(sprintf(
            'Done. Resized: %d, Skipped: %d, Failed: %d, Errors: %d',
            $resized,
            $skipped,
            $failed,
            $errors,
        ));

        return Command::SUCCESS;
    }

    /**
     * @return bool True if the image was actually resized and published, false if it was
     * silently skipped (e.g. the image resource could not be loaded/transformed this attempt).
     */
    private function resizeImage(Image $image, int $maxWidth, int $maxHeight): bool
    {
        $backend = $image->getImageBackend();

        $tmpImage = TEMP_PATH . '/resampled-' . mt_rand(100000, 999999) . '.' . $image->getExtension();

        file_put_contents($tmpImage, $image->getString());

        try {
            $backend->loadFrom($tmpImage);

            if (!$backend->getImageResource()) {
                return false;
            }

            if ($maxWidth && $maxHeight) {
                $transformed = $backend->resizeRatio($maxWidth, $maxHeight);
            } elseif ($maxWidth) {
                $transformed = $backend->resizeByWidth($maxWidth);
            } else {
                $transformed = $backend->resizeByHeight($maxHeight);
            }

            if (!$transformed) {
                return false;
            }

            if (!$transformed->writeTo($tmpImage)) {
                return false;
            }

            // Keep the old (oversized) file around until the new one is written and published -
            // deleting it upfront risks leaving the record with neither if a later step fails.
            $oldFilename = $image->FileFilename;
            $oldHash = $image->FileHash;

            $image->setFromLocalFile($tmpImage, $image->FileName);
            // Clear stale cached dimensions — FocusPoint doesn't recalculate them on write().
            if (class_exists(DBFocusPoint::class)) {
                $image->FocusPointWidth = 0;
                $image->FocusPointHeight = 0;
            }
            $image->write();
            // Publish to File_Live; without this the live site still serves the old file.
            $image->publishSingle();

            if (!Config::inst()->get(FlysystemAssetStore::class, 'legacy_filenames') && $oldHash !== $image->FileHash) {
                Injector::inst()->get(AssetStore::class)->delete($oldFilename, $oldHash);
            }

            return true;
        } finally {
            @unlink($tmpImage);
        }
    }
}
