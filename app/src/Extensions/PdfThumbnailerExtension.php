<?php

namespace App\Extensions;

use SilverStripe\Assets\Image;
use SilverStripe\Core\Extension;
use SilverStripe\Control\Director;
use SilverStripe\Core\Environment;

class PdfThumbnailerExtension extends Extension
{

    public function PDFThumbnail($page = 1)
    {

        $ghost_path = Environment::getEnv('GHOSTSCRIPT_PATH');

        // Only thumbnail PDF files
        if (strtolower($this->owner->getExtension()) != 'pdf') {
            return false;
        }

        // if a current-folder exists, we assume a symlinked baseFolder like with PHP deployer
        $current = dirname(dirname(Director::baseFolder())) . '/current';
        if (is_dir($current)) {
            $base = dirname(dirname(Director::baseFolder())) . '/shared';
        } else {
            $base = Director::baseFolder();
        }

        $original_filename_relative  = $this->owner->getFilename();
        $original_filename_absolute  = $base . '/public/assets/' . $original_filename_relative;

        // bail out if file doesn't exists
        if (!file_exists($original_filename_absolute)) return false;

        $filename_relative = $original_filename_relative . '.page-' . (int)$page . '.jpg';
        // ghostscript cannot create directories!
        $tmp_filename = sys_get_temp_dir() . '/' . basename($original_filename_relative) . '.page-' . (int)$page . '.jpg';
        $absolute_filename = $base . '/public/assets/' . $original_filename_relative . '.page-' . (int)$page . '.jpg';

        // Check for existing cached thumbnail and date
        if (is_file($absolute_filename)) {
            if (filemtime($absolute_filename) > filemtime($original_filename_absolute)) {
                $img = Image::get()->filter(['FileFilename' => $filename_relative])->first();
                if ($img) return $img;
            }
        }

        $command = $ghost_path . ' -sDEVICE=jpeg -dAutoRotatePages=/None -dFirstPage=' . $page . ' -dLastPage=' . $page . ' -dNOPAUSE -dJPEGQ=80 -dGraphicsAlphaBits=4 -dTextAlphaBits=4 -r144 -dUseTrimBox -sOutputFile=' . $tmp_filename . ' ' . $original_filename_absolute . ' -c quit';

        shell_exec($command . ' 2>&1');

        // bail out if generated file doesn't exists
        if (!file_exists($tmp_filename))
            return false;

        $img = new Image();
        $img->setFromLocalFile($tmp_filename, $filename_relative);
        $img->setFilename($filename_relative);
        $img->write();
        return $img;
    }
}
