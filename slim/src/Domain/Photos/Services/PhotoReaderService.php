<?php

declare(strict_types=1);

namespace App\Domain\Photos\Services;

use App\Application\Settings\SettingsInterface;

class PhotoReaderService
{
    /** @var SettingsInterface */
    private $settings;

    public function __construct(SettingsInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param int $userId
     * @param string $photoName
     * @return false|string
     */
    public function getUserPhoto(int $userId, string $photoName)
    {
        $filePath = sprintf(
            '%s/%d/%s.%s',
            $this->settings->get('images_dir'),
            $userId,
            $photoName,
            PhotoConvertorService::OUTPUT_EXTENSION
        );
        return file_get_contents($filePath);
    }
}