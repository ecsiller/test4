<?php

declare(strict_types=1);

namespace App\Domain\User\Repositories;

use App\Application\Repositories\AbstractRepository;
use App\Domain\User\Entities\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\Query\Parameter;

class UserRepository extends AbstractRepository
{
    /**
     * @param int $id
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneById(int $id): ?User
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.id = :user_id')
            ->setParameter('user_id', $id)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $token
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneByToken(string $token): ?User
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.apiToken = :api_token')
            ->setParameter('api_token', $token)
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     * @throws NonUniqueResultException
     */
    public function findOneByEmailAndPassword(string $email, string $password): ?User
    {
        return $this->em->createQueryBuilder()
            ->select('u')
            ->from(User::class, 'u')
            ->where('u.email = :user_email AND u.password = :user_password')
            ->setParameters(
                new ArrayCollection(
                    [
                        new Parameter('user_email', $email),
                        new Parameter('user_password', $password)
                    ]
                )
            )
            ->getQuery()
            ->getOneOrNullResult();
    }

    /**
     * @param User $user
     * @param int|null $age
     * @param string|null $gender
     *
     * @return User[]|null
     */
    public function findMatchingUsersByUserAgeGender(User $user, int $age = null, string $gender = null): ?array
    {
        $ageQuery = '';
        $genderQuery = '';
        $parameters = [
            'user_id' => $user->getId(),
            'preferred_number' => $user->getPreferredNumber(),
        ];
        if ($age) {
            $ageQuery = 'AND u.age = :age';
            $parameters['age'] = $age;
        }
        if ($gender) {
            $genderQuery = 'AND u.gender = :gender';
            $parameters['gender'] = $gender;
        }

        $query = sprintf(
            'SELECT u.id, u.email, u.name, u.gender, u.age, u.preferred_number, u.latitude, u.longitude, u.like_count
                  FROM users u
                  LEFT JOIN user_swipe us ON (u.id = us.referral_id)
                  LEFT JOIN users mu ON (mu.id = :user_id)
                  WHERE (u.id != :user_id
                  AND u.preferred_number = :preferred_number) 
                  %s
                  %s
                  AND NOT EXISTS (
                             SELECT 1
                             FROM user_swipe
                             WHERE user_swipe.user_id = :user_id
                             AND user_swipe.referral_id = u.id
                             )
                  ORDER BY ( SELECT ST_Distance_Sphere(
                                        point(mu.longitude, mu.latitude),
                                        point(u.longitude, u.latitude) )
                                        ) , u.like_count DESC ',
            $ageQuery,
            $genderQuery
        );

        return $this->executeQuery(
            $query,
            $parameters
        );
    }
}