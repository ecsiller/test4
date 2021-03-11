<?php

declare(strict_types=1);

namespace App\Domain\Photos\Services;

use App\Application\Settings\SettingsInterface;
use App\Domain\Photos\Exceptions\NotImageException;
use Slim\Psr7\UploadedFile;

class PhotoConvertorService
{
    /** @var int */
    private const WIDTH = 100;

    /** @var int */
    private const HEIGHT = 100;

    /** @var int */
    private const QUALITY = 100;

    /** @var string */
    public const OUTPUT_EXTENSION = 'jpeg';

    /** @var SettingsInterface */
    private $settings;

    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param int $userId
     * @param UploadedFile $uploadedFile
     * @param string $fileName
     * @throws NotImageException
     */
    public function handleUserPhoto(int $userId, UploadedFile $uploadedFile, string $fileName): void
    {
        $filePath = sprintf(
            '%s/%d/%s.%s',
            $this->settings->get('images_dir'),
            $userId,
            $fileName,
            self::OUTPUT_EXTENSION
        );
        if (!file_exists(dirname($filePath))) {
            mkdir(dirname($filePath), 0700, true);
        }
        $uploadedFile->moveTo($filePath);

        if (!getimagesize($filePath)) {
            unlink($filePath);
            throw new NotImageException();
        }
        $this->resize($filePath);
    }

    /**
     * @param $filePath
     */
    private function resize($filePath): void
    {
        [$width, $height] = getimagesize($filePath);
        $thumb = imagecreatetruecolor(self::WIDTH, self::HEIGHT);
        $source = imagecreatefromstring(file_get_contents($filePath));
        imagecopyresized($thumb, $source, 0, 0, 0, 0, self::WIDTH, self::HEIGHT, $width, $height);
        imagejpeg($thumb, $filePath, self::QUALITY);
    }
}