<?php

declare(strict_types=1);

namespace App\Domain\Photos\Entities;

use App\Domain\User\Entities\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="App\Domain\Photos\Repositories\PhotoRepository")
 * @Table(name="user_photos")
 */
class Photo
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
     * @var string
     *
     * @Column(type="string", name="name", length=100, nullable=false)
     */
    private $name;

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
     * @return Photo
     */
    public function setUser(User $user): Photo
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Photo
     */
    public function setName(string $name): Photo
    {
        $this->name = $name;
        return $this;
    }
}