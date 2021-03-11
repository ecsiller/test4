<?php

declare(strict_types=1);

namespace App\Domain\Photos\Factories;

use App\Domain\Photos\Entities\Photo;
use App\Domain\User\Entities\User;

class PhotoFactory
{
    /**
     * @param User $user
     * @param string $fileName
     * @return Photo
     */
    public function create(User $user, string $fileName): Photo
    {
        return (new Photo())
            ->setUser($user)
            ->setName($fileName);
    }
}