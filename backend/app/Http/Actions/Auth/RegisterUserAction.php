<?php

declare(strict_types=1);

namespace App\Http\Actions\Auth;

use App\Http\Adapters\Auth\RegisterUserAdapter;
use App\Application\Handlers\Auth\RegisterUserHandler;
use App\Http\Actions\BaseAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterUserAction extends BaseAction
{
    public function __construct(
        private RegisterUserAdapter $adapter,
        private RegisterUserHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response): Response
    {
        $command = $this->adapter->adapt($request);
        $result = $this->handler->handle($command);
        
        return $this->respondWithData($response, $result);
    }
}