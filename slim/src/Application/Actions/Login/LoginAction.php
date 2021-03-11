<?php

declare(strict_types=1);

namespace App\Application\Actions\Login;

use App\Application\Actions\Action;
use App\Domain\Login\Services\TokenGeneratorService;
use App\Domain\User\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;

class LoginAction extends Action
{
    /** @var EntityManager */
    private $em;

    /** @var UserRepository */
    private $userRepository;

    /** @var TokenGeneratorService */
    private $tokenGeneratorService;

    public function __construct(
        EntityManager $em,
        UserRepository $userRepository,
        TokenGeneratorService $tokenGeneratorService
    ) {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->tokenGeneratorService = $tokenGeneratorService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->validateRequiredParameters(['email','password']);
        $user = $this->userRepository->findOneByEmailAndPassword(
            $this->getFormData()->email,
            $this->getFormData()->password
        );
        if (!$user) {
            return $this->respondWithData(
                ['Invalid credentials please try again'],
                self::HTTP_OK
            );
        }
        $token = $this->tokenGeneratorService->getToken();
        $user->setApiToken($token);
        $this->em->persist($user);
        $this->em->flush();

        return $this->respondWithData(
            [compact('token')],
            self::HTTP_CREATED
        );
    }
}
