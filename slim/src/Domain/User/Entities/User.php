<?php

declare(strict_types=1);

namespace App\Domain\User\Entities;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;

/**
 * @Entity(repositoryClass="App\Domain\User\Repositories\UserRepository")
 * @Table(name="users")
 */
class User
{
    /** @var string */
    public const MALE = 'M';

    /** @var string */
    public const FEMALE = 'F';

    /** @var string */
    public const OTHER = 'O';

    /**
     * @var int
     *
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @Column(type="string", name="email", length=100, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @Column(type="string", name="password", length=250, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @Column(type="string", name="name", length=100, nullable=false)
     */
    private $name;

    /**
     * @var string
     *
     * @Column(type="string", name="api_token", length=250, nullable=false, unique=true)
     */
    private $apiToken;

    /**
     * @var string
     *
     * @Column(type="string", columnDefinition="ENUM('M', 'F', 'O')")
     */
    private $gender;

    /**
     * @var int
     *
     * @Column(type="integer", name="age", length=3, nullable=false)
     */
    private $age;

    /**
     * @var int
     *
     * @Column(type="integer", name="preferred_number", length=11, nullable=false)
     */
    private $preferredNumber;

    /**
     * @var float
     *
     * @Column(type="decimal", name="latitude", nullable=false)
     */
    private $latitude;

    /**
     * @var float
     *
     * @Column(type="decimal", name="longitude", nullable=false)
     */
    private $longitude;


    /**
     * @var int
     *
     * @Column(type="integer", name="like_count", length=11, nullable=false)
     */
    private $likeCount = 0;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
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
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getGender(): string
    {
        return $this->gender;
    }

    /**
     * @param string $gender
     * @return User
     */
    public function setGender(string $gender): User
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return int
     */
    public function getAge(): int
    {
        return $this->age;
    }

    /**
     * @param int $age
     * @return User
     */
    public function setAge(int $age): User
    {
        $this->age = $age;
        return $this;
    }

    /**
     * @return float
     */
    public function getLatitude(): float
    {
        return $this->latitude;
    }

    /**
     * @param float $latitude
     * @return User
     */
    public function setLatitude(float $latitude): User
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return float
     */
    public function getLongitude(): float
    {
        return $this->longitude;
    }

    /**
     * @param float $longitude
     * @return User
     */
    public function setLongitude(float $longitude): User
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiToken(): string
    {
        return $this->apiToken;
    }

    /**
     * @param string $apiToken
     * @return User
     */
    public function setApiToken(string $apiToken): User
    {
        $this->apiToken = $apiToken;
        return $this;
    }

    /**
     * @return int
     */
    public function getPreferredNumber(): int
    {
        return $this->preferredNumber;
    }

    /**
     * @param int $preferredNumber
     * @return User
     */
    public function setPreferredNumber(int $preferredNumber): User
    {
        $this->preferredNumber = $preferredNumber;
        return $this;
    }

    /**
     * @return int
     */
    public function getLikeCount(): int
    {
        return $this->likeCount;
    }

    /**
     * @param int $likeCount
     * @return User
     */
    public function setLikeCount(int $likeCount): User
    {
        $this->likeCount = $likeCount;
        return $this;
    }

    /**
     * @return $this
     */
    public function incrementLikeCount(): User
    {
        ++$this->likeCount;
        return $this;
    }
}