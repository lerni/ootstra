<?php

namespace App\Extensions;

use Psr\Log\LoggerInterface;
use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;
use SilverStripe\Assets\Image_Backend;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Assets\Storage\AssetStore;
use SilverStripe\Assets\FilenameParsing\AbstractFileIDHelper;

/**
 * Extension to add a method to convert a PDF to an image.
 */
class PDFImageExtension extends Extension
{
    /**
     * Create a variant of a PDF as image.
     *
     * @param string $newExtension The file extension of the formatted file, "png" or "jpg"
     * @param int $width The width of the formatted file in px
     * @param int $page The page of the PDF to convert
     * @param int $quality The quality of the output image for jpg files form 0 to 100
     */
    public function PDFImage(string $newExtension = 'png', int $width = 2000, int $page = 1, int $quality = 96): ?DBFile
    {
        $original = $this->getOwner();

        // Only working with PDF files
        if (strtolower($original->getExtension()) !== 'pdf') {
            return null;
        }

        $pathParts = pathinfo($this->getOwner()->getFilename());

        $variant = $this->getOwner()->variantName(__FUNCTION__, AbstractFileIDHelper::EXTENSION_REWRITE_VARIANT, $pathParts['extension'], $newExtension, $width, $page, $quality);

        return $original->manipulateExtension(
        // TODO: we should use manipulateImage or just manipulate here, and make sure all parameters are respected in
        // return $original->manipulateImage(
            $newExtension,
            // $variant,
            function (AssetStore $store, string $filename, string $hash, string $variant) use ($newExtension, $width, $page, $quality) {
                $ghost_path = Environment::getEnv('GHOSTSCRIPT_PATH') ?: 'gs';

                // TODO: this is a bit of a hack to get the original filename - lets use AssetStore::getFullPath or something instead
                // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
                $base = Director::baseFolder();
                $current = dirname($base, 2) . '/current';
                $basePath = is_dir($current) ? dirname($base, 2) . '/shared' : $base;

                $original_filename_relative = $this->getOwner()->getFilename();
                $original_filename_absolute = $basePath . '/public/assets/' . $original_filename_relative;

                // bail out if file doesn't exists
                if (!file_exists($original_filename_absolute)) {
                    return null;
                }

                $tmp_filename = sys_get_temp_dir() . '/' . basename($original_filename_relative) . '.page-' . $page . '-width-' . $width . '-quality-' . $quality . '.' . $newExtension;
                $gsDevice = $newExtension === 'png' ? 'png16m' : 'jpeg';

                $commandParts = [
                    escapeshellcmd($ghost_path),
                    '-sDEVICE=' . $gsDevice,
                    '-dAutoRotatePages=/None',
                    '-dFirstPage=' . $page,
                    '-dLastPage=' . $page,
                    '-dNOPAUSE',
                    '-dJPEGQ=' . $quality,
                    '-dGraphicsAlphaBits=4',
                    '-dTextAlphaBits=4',
                    '-r144',
                    '-dUseTrimBox',
                    '-sOutputFile=' . $tmp_filename,
                    $original_filename_absolute,
                    '-c quit'
                ];
                $command = implode(' ', array_map('escapeshellarg', $commandParts));
                //$command = escapeshellcmd($ghost_path) . ' -sDEVICE=' . escapeshellarg($gsDevice) . ' -dAutoRotatePages=/None -dFirstPage=' . (int)$page . ' -dLastPage=' . (int)$page . ' -dNOPAUSE -dJPEGQ=' . (int)$quality . ' -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -r144 -dUseTrimBox -sOutputFile=' . escapeshellarg($tmp_filename) . ' ' . escapeshellarg($original_filename_absolute) . ' -c quit';

                exec($command, $output, $returnCode);
                if ($returnCode !== 0) {
                    Injector::inst()->get(LoggerInterface::class)->error('Ghostscript conversion failed: ' . implode("\n", $output));
                }

                // bail out if generated file doesn't exists
                if (!file_exists($tmp_filename)) {
                    return null;
                }

                $backend = Injector::inst()->create(Image_Backend::class);
                // Images/variants do not have a focuspoint!
                $backend->loadFrom($tmp_filename);
                $config = ['conflict' => AssetStore::CONFLICT_USE_EXISTING];
                $tuple = $backend->writeToStore($store, $filename, $hash, $variant, $config);

                // Clean up temporary file
                unlink($tmp_filename);

                return [$tuple, $backend];
            }
        );
    }
}
