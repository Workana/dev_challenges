<?php

declare(strict_types=1);

use App\Http\Actions\Issues\GetIssueAction;
use App\Http\Actions\Issues\JoinIssueAction;
use App\Http\Actions\Issues\VoteIssueAction;
use App\Http\Middlewares\AuthenticateMiddleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Routing\RouteCollectorProxy;

return function (Slim\App $app) {
    $app->get('/', function (Request $request, Response $response) {
        $response->getBody()->write('Api works!');
        return $response->withHeader('Content-Type', 'application/json');
    });

    $app->post('/user/signup', App\Http\Actions\Auth\RegisterUserAction::class);

    $app->group('/issue', function (RouteCollectorProxy $group) {
        $group->get('/{issue}', GetIssueAction::class);
        $group->post('/{issue}/join', JoinIssueAction::class);
        $group->post('/{issue}/vote', VoteIssueAction::class);
    })->add(AuthenticateMiddleware::class);
};
