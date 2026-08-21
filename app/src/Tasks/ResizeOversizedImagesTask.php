<?php

namespace App\Tasks;

use SilverStripe\Assets\Image;
use SilverStripe\Dev\BuildTask;
use SilverStripe\Core\Config\Config;
use Axllent\ScaledUploads\ScaledUploads;
use SilverStripe\PolyExecution\PolyOutput;
use JonoM\FocusPoint\FieldType\DBFocusPoint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use SilverStripe\Assets\Flysystem\FlysystemAssetStore;

/**
 * Resize all source images that exceed the configured ScaledUploads limits.
 * Reads max_width / max_height from Axllent\ScaledUploads\ScaledUploads config.
 *
 * Run via: php ./vendor/bin/sake tasks:resize-oversized-images
 */
class ResizeOversizedImagesTask extends BuildTask
{
    protected static string $commandName = 'resize-oversized-images';

    protected string $title = 'Resize oversized source images';

    protected static string $description = 'Scales down source images that exceed the ScaledUploads max_width / max_height config values.';

    protected function execute(InputInterface $input, PolyOutput $output): int
    {
        $maxWidth = (int) Config::inst()->get(ScaledUploads::class, 'max_width') ?: 4000;
        $maxHeight = (int) Config::inst()->get(ScaledUploads::class, 'max_height') ?: 4000;

        if (!$maxWidth && !$maxHeight) {
            $output->writeln('No max_width or max_height configured — nothing to do.');

            return Command::SUCCESS;
        }

        $output->writeln(sprintf('Max dimensions: %dpx × %dpx', $maxWidth, $maxHeight));

        // Only process source files — variants have a non-null FileVariant
        $images = Image::get()->filter(['FileVariant' => null]);
        $total = $images->count();

        $output->writeln(sprintf('Checking %d source images…', $total));

        $resized = 0;
        $skipped = 0;
        $errors = 0;
        $hasFocusPoint = class_exists(DBFocusPoint::class);

        foreach ($images as $image) {
            $width = $hasFocusPoint ? $image->FocusPoint->getWidth() : $image->getWidth();
            $height = $hasFocusPoint ? $image->FocusPoint->getHeight() : $image->getHeight();

            if (!$width || !$height) {
                ++$skipped;

                continue;
            }

            $needsResize = ($maxWidth && $width > $maxWidth) || ($maxHeight && $height > $maxHeight);

            if (!$needsResize) {
                ++$skipped;

                continue;
            }

            try {
                $this->resizeImage($image, $maxWidth, $maxHeight);
                $output->writeln(sprintf(
                    '  Resized: %s (%dx%d)',
                    $image->FileFilename,
                    $width,
                    $height,
                ));
                ++$resized;
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
            'Done. Resized: %d, Skipped: %d, Errors: %d',
            $resized,
            $skipped,
            $errors,
        ));

        return Command::SUCCESS;
    }

    private function resizeImage(Image $image, int $maxWidth, int $maxHeight): void
    {
        $backend = $image->getImageBackend();

        $tmpImage = TEMP_PATH . '/resampled-' . mt_rand(100000, 999999) . '.' . $image->getExtension();

        file_put_contents($tmpImage, $image->getString());

        try {
            $backend->loadFrom($tmpImage);

            if (!$backend->getImageResource()) {
                return;
            }

            if ($maxWidth && $maxHeight) {
                $transformed = $backend->resizeRatio($maxWidth, $maxHeight);
            } elseif ($maxWidth) {
                $transformed = $backend->resizeByWidth($maxWidth);
            } else {
                $transformed = $backend->resizeByHeight($maxHeight);
            }

            if (!$transformed) {
                return;
            }

            $transformed->writeTo($tmpImage);

            if (!Config::inst()->get(FlysystemAssetStore::class, 'legacy_filenames')) {
                $image->File->deleteFile();
            }

            $image->setFromLocalFile($tmpImage, $image->FileName);
            // Clear stale cached dimensions — FocusPoint doesn't recalculate them on write().
            if (class_exists(DBFocusPoint::class)) {
                $image->FocusPointWidth = 0;
                $image->FocusPointHeight = 0;
            }
            $image->write();
            // Publish to File_Live; without this the live site still serves the now-deleted old file.
            $image->publishSingle();
        } finally {
            @unlink($tmpImage);
        }
    }
}
