<?php

declare(strict_types=1);

namespace App\Domain\User\Factories;

use App\Domain\Login\Services\TokenGeneratorService;
use App\Domain\User\Entities\User;
use Faker\Geo;
use Faker\Internet;
use Faker\Name;

class UserFactory
{
    /** @var TokenGeneratorService */
    private $tokenGeneratorService;

    public function __construct(TokenGeneratorService $tokenGeneratorService)
    {
        $this->tokenGeneratorService = $tokenGeneratorService;
    }

    /**
     * @return User
     */
    public function createRandomUser(): User
    {
        $name = Name::name();
        return (new User())
            ->setPassword($this->getRandomString())
            ->setLongitude(Geo::longitude())
            ->setLatitude(Geo::latitude())
            ->setEmail(Internet::email($name))
            ->setName($name)
            ->setApiToken($this->tokenGeneratorService->getToken())
            ->setGender(rand(1, 10) > 5 ? User::FEMALE : User::MALE)
            ->setAge(rand(18, 100))
            ->setPreferredNumber(rand(1, 10));
    }

    /**
     * @param int $length
     * @return string
     */
    private function getRandomString($length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}