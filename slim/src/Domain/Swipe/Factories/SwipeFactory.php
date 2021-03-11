<?php

declare(strict_types=1);

namespace App\Domain\Swipe\Factories;

use App\Domain\Swipe\Entities\Swipe;
use App\Domain\User\Entities\User;

class SwipeFactory
{
    /**
     * @param User $referral
     * @param User $user
     * @param bool $like
     * @return Swipe
     */
    public function create(User $referral, User $user, bool $like): Swipe
    {
        return (new Swipe())
            ->setLikes($like)
            ->setReferral($referral)
            ->setUser($user);
    }
}