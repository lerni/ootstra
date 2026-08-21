<?php

namespace App\Conversion;

use SilverStripe\Assets\File;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Assets\Conversion\InterventionImageFileConverter;

// Applies a lower quality for AVIF encoding since its codec is far more
// efficient than JPEG — Q55 AVIF ≈ Q75 JPEG in perceptual quality.
class AvifFileConverter extends InterventionImageFileConverter
{
    use Configurable;

    private static int $avif_quality = 55;

    public function convert(DBFile|File $from, string $toExtension, array $options = []): DBFile
    {
        if (strtolower($toExtension) === 'avif' && !isset($options['quality'])) {
            $options['quality'] = $this->config()->get('avif_quality');
        }

        return parent::convert($from, $toExtension, $options);
    }
}
