<?php

declare(strict_types=1);

namespace App\Http\Actions;

use Psr\Http\Message\ResponseInterface as Response;

class BaseAction
{
    public function respondWithArray(Response $response, array $result): Response
    {
        $response->getBody()->write(json_encode(['payload' => $result]));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function respondWithData(Response $response, string $result): Response
    {
        $response->getBody()->write(json_encode(['payload' => [
            $result
        ]]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}