<?php

namespace App\Conversion;

use Psr\Log\LoggerInterface;
use SilverStripe\Assets\File;
use SilverStripe\Assets\Storage\DBFile;
use SilverStripe\Core\Injector\Injector;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Assets\Conversion\FileConverterException;
use SilverStripe\Assets\Conversion\InterventionImageFileConverter;

// Applies a lower quality for AVIF encoding since its codec is far more
// efficient than JPEG — Q55 AVIF ≈ Q75 JPEG in perceptual quality.
// https://www.industrialempathy.com/posts/avif-webp-quality-settings/
class AvifFileConverter extends InterventionImageFileConverter
{
    use Configurable;

    private static int $avif_quality = 55;

    public function convert(DBFile|File $from, string $toExtension, array $options = []): DBFile
    {
        if (strtolower($toExtension) === 'avif' && !isset($options['quality'])) {
            $options['quality'] = $this->config()->get('avif_quality');
        }

        try {
            return parent::convert($from, $toExtension, $options);
        } catch (FileConverterException $e) {
            // The core only logs the outer message, the libvips cause is in the previous exceptions
            $causes = [];
            for ($previous = $e; $previous; $previous = $previous->getPrevious()) {
                $causes[] = $previous->getMessage();
            }
            Injector::inst()->get(LoggerInterface::class)->error(
                sprintf('Conversion of "%s" to %s failed: %s', $from->getFilename(), $toExtension, implode(' <- ', $causes)),
            );

            // An already scaled variant is still a usable image, better than an empty src
            if ($from instanceof DBFile) {
                return $from;
            }

            throw $e;
        }
    }
}
