<?php

declare(strict_types=1);

use App\Application\Actions\Login\LoginAction;
use App\Application\Actions\Photos\AddPhotoAction;
use App\Application\Actions\Photos\ServePhotoAction;
use App\Application\Actions\Profiles\FetchMatchingProfilesAction;
use App\Application\Actions\Swipe\UserSwipeAction;
use App\Application\Actions\User\CreateUserAction;
use App\Application\Middleware\TokenMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $app->options(
        '/{routes:.*}',
        function (Request $request, Response $response) {
            // CORS Pre-Flight OPTIONS Request Handler
            return $response;
        }
    );

    $app->get(
        '/',
        function (Request $request, Response $response) {
            $response->getBody()->write('Hello world!');
            return $response;
        }
    );
    $app->post('/login', LoginAction::class);
    $app->get('/assets/{userId}/{image}', ServePhotoAction::class)->add(TokenMiddleware::class);

    $app->group(
        '/user',
        function (Group $group) {
            $group->post('/create', CreateUserAction::class);
            $group->post('/gallery', AddPhotoAction::class)
                ->add(TokenMiddleware::class);
        }
    );
    $app->group(
        '',
        function (Group $group) {
            $group->post('/profiles', FetchMatchingProfilesAction::class);
            $group->post('/swipe', UserSwipeAction::class);
        }
    )
        ->add(TokenMiddleware::class);
};
