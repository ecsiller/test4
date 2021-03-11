<?php

declare(strict_types=1);

namespace App\Application\Actions\Photos;

use App\Application\Actions\Action;
use App\Domain\Photos\Factories\PhotoFactory;
use App\Domain\Photos\Services\PhotoConvertorService;
use App\Domain\User\Entities\User;
use Doctrine\ORM\EntityManager;
use Psr\Http\Message\ResponseInterface as Response;

class AddPhotoAction extends Action
{
    /** @var EntityManager */
    private $em;

    /** @var PhotoFactory */
    private $photoFactory;

    /** @var PhotoConvertorService */
    private $photoConvertorService;

    public function __construct(
        EntityManager $em,
        PhotoFactory $photoFactory,
        PhotoConvertorService $photoConvertorService
    ) {
        $this->em = $em;
        $this->photoFactory = $photoFactory;
        $this->photoConvertorService = $photoConvertorService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        /** @var User $user */
        $user = $this->request->getAttribute('user');
        $response = [];
        foreach ($this->request->getUploadedFiles() as $uploadedFile) {
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                [$fileName, $extension] = explode('.', $uploadedFile->getClientFilename());
                $photoInstance = $this->photoFactory->create($user, $fileName);
                $this->photoConvertorService->handleUserPhoto($user->getId(),$uploadedFile,$fileName);
                $this->em->persist($photoInstance);
                $this->em->flush();
                $response[] = $fileName;
            }
        }

        return $this->respondWithData(
            $response,
            self::HTTP_CREATED
        );
    }
}
