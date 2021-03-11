<?php

declare(strict_types=1);

namespace App\Domain\Swipe\Entities;

use App\Domain\User\Entities\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity()
 * @Table(name="user_swipe")
 */
class Swipe
{
    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\User\Entities\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @var int
     *
     * @ORM\ManyToOne(targetEntity="App\Domain\User\Entities\User", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $referral;

    /**
     * @var bool
     *
     * @Column(type="boolean", name="likes", nullable=false)
     */
    private $likes;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getUser(): int
    {
        return $this->user;
    }

    /**
     * @param User $user
     * @return Swipe
     */
    public function setUser(User $user): Swipe
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return int
     */
    public function getReferral(): int
    {
        return $this->referral;
    }

    /**
     * @param User $referral
     * @return Swipe
     */
    public function setReferral(User $referral): Swipe
    {
        $this->referral = $referral;
        return $this;
    }

    /**
     * @return bool
     */
    public function isLike(): bool
    {
        return $this->likes;
    }

    /**
     * @param bool $likes
     * @return Swipe
     */
    public function setLikes(bool $likes): Swipe
    {
        $this->likes = $likes;
        return $this;
    }
}