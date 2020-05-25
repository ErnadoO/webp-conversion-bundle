<?php

namespace CodeBuds\WebPConversionBundle\Service;

use CodeBuds\WebPConversionBundle\Model\Image;
use CodeBuds\WebPConverter\WebPConverter;
use Exception;

class ImageConverter
{
    /**
     * @param Image $image
     * @param bool $saveFile
     * @param bool $force
     * @return array|mixed
     * @throws Exception
     */
    public function convert(Image $image, bool $force = false, bool $saveFile = true)
    {
        $options = $this->createOptionsArray($image);
        $options['saveFile'] = $saveFile;
        $options['force'] = $force;

        $webPInfo = WebPConverter::createWebPImage($image->getFile(), $options);

        if (!$saveFile) {
            return $webPInfo;
        }

        return $webPInfo['path'];
    }

    /**
     * @param Image $image
     * @return bool
     * @throws Exception
     */
    public function convertedImageExists(Image $image): bool
    {
        return WebPConverter::convertedWebPImageExists($image->getFile(), $this->createOptionsArray($image));
    }

    private function createOptionsArray(Image $image): array
    {
        return [
            'quality' => $image->getSettings()->getQuality(),
            'savePath' => $image->getSettings()->getConvertedPath(),
            'filename' => $image->getSettings()->getConvertedFilename(),
            'filenameSuffix' => $image->getSettings()->getConvertedFilenameSuffix()
        ];
    }
}