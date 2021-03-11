<?php

declare(strict_types=1);

namespace App\Domain\Swipe\Repositories;

use App\Application\Repositories\AbstractRepository;
use App\Domain\User\Entities\User;
use App\Domain\Swipe\Entities\Swipe;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Parameter;

class SwipeRepository extends AbstractRepository
{
    /**
     * @param User $user
     * @param User $referral
     * @return null|Swipe
     * @throws NonUniqueResultException
     */
    public function getSwipeByUserAndReferral(User $user, User $referral): ?Swipe
    {
        return $this->em->createQueryBuilder()
            ->select('s')
            ->from(Swipe::class, 's')
            ->where('s.user = :user_id AND s.referral = :referral_id')
            ->setParameters(
                new ArrayCollection(
                    [
                        new Parameter('user_id', $user->getId()),
                        new Parameter('referral_id', $referral->getId())
                    ]
                )
            )
            ->getQuery()
            ->getOneOrNullResult();
    }
}