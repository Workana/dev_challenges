<?php

declare(strict_types=1);

namespace App\Http\Actions\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Application\Handlers\Auth\RegisterUserHandler;
use App\Http\Actions\BaseAction;
use Assert\Assertion;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class RegisterUserAction extends BaseAction
{
    private const USERNAME_PARAM = 'username';

    public function __construct(
        private RegisterUserHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();

        Assertion::keyExists($data, self::USERNAME_PARAM);
        Assertion::notNull($data[self::USERNAME_PARAM]);

        $result = $this->handler->handle(new RegisterUserCommand(
            $data[self::USERNAME_PARAM]
        ));
        
        return $this->respondWithData($response, $result);
    }
}