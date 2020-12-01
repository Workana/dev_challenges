<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

return function (Slim\App $app) {
    $app->get('/issue/{number}', function (Request $request, Response $response, array $args) {
        $number = $args['number'];
        $response->getBody()->write(json_encode(['issue' => $number]));
        return $response->withHeader('Content-Type', 'application/json');
    });
};
