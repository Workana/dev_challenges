<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    private int $statusCode;

    public function __construct()
    {
        parent::__construct('Unauthorized');
        $this->statusCode = 401;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function getResponseMessage(): string
    {
        return $this->responseMessage;
    }
}