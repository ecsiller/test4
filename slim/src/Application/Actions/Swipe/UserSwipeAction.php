<?php

declare(strict_types=1);

namespace App\Application\Actions\Swipe;

use App\Application\Actions\Action;
use App\Domain\Swipe\Factories\SwipeFactory;
use App\Domain\Swipe\Repositories\SwipeRepository;
use App\Domain\User\Repositories\UserRepository;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;

class UserSwipeAction extends Action
{
    /** @var SwipeRepository */
    private $swipeRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var EntityManager */
    private $em;

    /** @var SwipeFactory */
    private $swipeFactory;

    /** @var string */
    public const MATCH_RESPONSE = 'There is a match';

    /** @var string */
    public const NO_MATCH_RESPONSE = 'No match';

    /** @var string */
    private const LIKE = 'YES';

    private const DISLIKE = 'NO';

    /** @var string[] */
    private const ALLOWED_VALUES = [self::LIKE, self::DISLIKE];

    public function __construct(
        SwipeRepository $swipeRepository,
        UserRepository $userRepository,
        EntityManager $em,
        SwipeFactory $swipeFactory
    ) {
        $this->swipeRepository = $swipeRepository;
        $this->userRepository = $userRepository;
        $this->em = $em;
        $this->swipeFactory = $swipeFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->validateRequiredParameters(['referral_id', 'like']);
        $user = $this->request->getAttribute('user');
        $referral = $this->userRepository->findOneById($this->getFormData()->referral_id);
        if (!$referral) {
            return $this->respondWithData(
                ['User not found'],
                self::HTTP_OK
            );
        }
        if (!in_array($this->getFormData()->like, self::ALLOWED_VALUES, true)) {
            throw new HttpBadRequestException($this->request);
        }
        $like = $this->getFormData()->like === self::LIKE;
        $userSwipe = $this->swipeRepository->getSwipeByUserAndReferral($user, $referral);
        if (!$userSwipe) {
            $userSwipe = $this->swipeFactory->create($referral, $user, $like);
            $this->em->persist($userSwipe);
            $this->em->flush();
        }
        if (!$like) {
            return $this->respondWithData(
                [self::NO_MATCH_RESPONSE],
                self::HTTP_OK
            );
        }
        $this->em->persist($referral->incrementLikeCount());
        $this->em->flush();
        $referralSwipe = $this->swipeRepository->getSwipeByUserAndReferral($referral, $user);
        if (!$referralSwipe) {
            return $this->respondWithData(
                [self::NO_MATCH_RESPONSE],
                self::HTTP_OK
            );
        }

        return $this->respondWithData(
            $referralSwipe->isLike() ? [self::MATCH_RESPONSE] : [self::NO_MATCH_RESPONSE],
            self::HTTP_OK
        );
    }
}
