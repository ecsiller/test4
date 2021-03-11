<?php

declare(strict_types=1);

namespace App\Application\Actions\Photos;

use App\Application\Actions\Action;
use App\Domain\Photos\Services\PhotoReaderService;
use Psr\Http\Message\ResponseInterface as Response;

class ServePhotoAction extends Action
{
    /** @var PhotoReaderService */
    private $photoReaderService;

    public function __construct(

        PhotoReaderService $photoReaderService
    ) {
        $this->photoReaderService = $photoReaderService;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $this->response->getBody()->write(
            $this->photoReaderService->getUserPhoto(
                (int)$this->resolveArg('userId'),
                $this->resolveArg('image')
            )
        );
        return $this->response
            ->withHeader('Content-Type', 'image/jpeg')
            ->withStatus(self::HTTP_OK);
    }
}
