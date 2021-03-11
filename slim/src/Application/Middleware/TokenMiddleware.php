<?php

declare(strict_types=1);

namespace App\Application\Middleware;

use App\Domain\User\Repositories\UserRepository;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface as Middleware;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpUnauthorizedException;

class TokenMiddleware implements Middleware
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Request $request, RequestHandler $handler): Response
    {
        $token = $request->getHeader('Api-Token');
        if (isset($token[0]) && $user = $this->userRepository->findOneByToken($token[0])) {
            $request = $request->withAttribute('user', $user);
            return $handler->handle($request);
        }
        throw new HttpUnauthorizedException($request);
    }
}
