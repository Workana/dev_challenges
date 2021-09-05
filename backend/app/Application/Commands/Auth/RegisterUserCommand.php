<?php

declare(strict_types=1);

namespace App\Application\Commands\Auth;

class RegisterUserCommand
{   
    public function __construct(
        private string $name
    ) { }

    public function getName(): string
    {
        return $this->name;
    }
}