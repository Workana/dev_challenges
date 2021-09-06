<?php

declare(strict_types=1);

namespace app\Http\Adapters\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Application\Exceptions\InvalidBodyException;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterUserAdapter
{
    private const USERNAME_PARAM = 'username';
    
    public function adapt(Request $request): RegisterUserCommand
    {
        $data = $request->getParsedBody();
        $name = $data[self::USERNAME_PARAM] ?: null;
        
        if (!$name) {
            throw new InvalidBodyException('Missing argument: ' . self::USERNAME_PARAM);
        }

        return new RegisterUserCommand(
            $name
        );
    }
}