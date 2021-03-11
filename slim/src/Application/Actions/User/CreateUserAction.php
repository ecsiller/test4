<?php

declare(strict_types=1);

namespace App\Application\Actions\User;

use App\Application\Actions\Action;
use App\Domain\User\Factories\UserFactory;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;

class CreateUserAction extends Action
{
    /** @var EntityManager */
    private $em;

    /** @var UserFactory */
    private $userFactory;

    public function __construct(EntityManager $em, UserFactory $userFactory)
    {
        $this->em = $em;
        $this->userFactory = $userFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $newUser = $this->userFactory->createRandomUser();
        $this->em->persist($newUser);
        $this->em->flush();

        return $this->respondWithData(
            [
                'id' => $newUser->getId(),
                'email' => $newUser->getEmail(),
                'password' => $newUser->getPassword(),
                'name' => $newUser->getName(),
                'gender' => $newUser->getGender(),
                'age' => $newUser->getAge(),
            ],
            self::HTTP_CREATED
        );
    }
}
