<?php

declare(strict_types=1);

namespace App\Domain\Photos\Repositories;

use App\Application\Repositories\AbstractRepository;
use App\Domain\Photos\Entities\Photo;

class PhotoRepository extends AbstractRepository
{

    /**
     * @param int $userId
     * @return Photo[]|null
     */
    public function findByUserId(int $userId): ?array
    {
        return $this->em->createQueryBuilder()
            ->select('p')
            ->from(Photo::class, 'p')
            ->where('p.user = :user_id')
            ->setParameter('user_id', $userId)
            ->getQuery()
            ->getResult();
    }

}