<?php

declare(strict_types=1);

namespace App\Domain\Photos\Services;

use App\Domain\Photos\Repositories\PhotoRepository;

class PhotoUrlGenerator
{
    /** @var PhotoRepository */
    private $photoRepository;

    public function __construct(PhotoRepository $photoRepository)
    {
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param int $userId
     * @param string $host
     * @return array
     */
    public function getPhotosUrlByUserId(int $userId, string $host): array
    {
        $urls = [];
        $photos = $this->photoRepository->findByUserId($userId);
        foreach ($photos as $photo) {
            $urls[] = sprintf(
                '%s/assets/%d/%s',
                $host,
                $userId,
                $photo->getName()
            );
        }

        return $urls;
    }
}