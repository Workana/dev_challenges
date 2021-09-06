<?php

declare(strict_types=1);

namespace App\Http\Adapters\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Application\Exceptions\InvalidBodyException;
use Psr\Http\Message\ServerRequestInterface as Request;

class RegisterUserAdapter
{
    private const USERNAME_PARAM = 'username';
    
    public function adapt(Request $request): RegisterUserCommand
    {
        $data = $request->getParsedBody();
        if (key_exists(self::USERNAME_PARAM, $data)){
            $name = $data[self::USERNAME_PARAM] ?: null;
        } else {
            $name = null;
        }
        
        if (!$name) {
            throw new InvalidBodyException('Missing argument: ' . self::USERNAME_PARAM);
        }

        return new RegisterUserCommand(
            $name
        );
    }
}