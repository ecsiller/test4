<?php

declare(strict_types=1);

namespace App\Application\Actions\Profiles;

use App\Application\Actions\Action;
use App\Domain\Photos\Services\PhotoUrlGenerator;
use App\Domain\User\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;

class FetchMatchingProfilesAction extends Action
{
    /** @var string */
    private const PHOTOS_KEY = 'photos';

    /** @var string */
    private const USER_KEY = 'user';

    /** @var string */
    private const ID_KEY = 'id';

    /** @var UserRepository */
    private $userRepository;

    /** @var PhotoUrlGenerator */
    private $photoUrlGenerator;

    public function __construct(UserRepository $userRepository, PhotoUrlGenerator $photoUrlGenerator)
    {
        $this->userRepository = $userRepository;
        $this->photoUrlGenerator = $photoUrlGenerator;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $users = $this->userRepository->findMatchingUsersByUserAgeGender(
            $this->request->getAttribute(self::USER_KEY),
            $this->getFormData()->age ?? null,
            $this->getFormData()->gender ?? null
        );
        foreach ($users as $key => $value) {
            $users[$key][self::PHOTOS_KEY] = $this->photoUrlGenerator->getPhotosUrlByUserId(
                (int)$value[self::ID_KEY],
                $this->request->getUri()->getHost()
            );
        }

        return $this->respondWithData(
            ['users' => $users],
            self::HTTP_OK
        );
    }
}
