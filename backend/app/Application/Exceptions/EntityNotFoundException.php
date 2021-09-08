<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Exception;

class EntityNotFoundException extends Exception
{
    private int $statusCode;

    public function __construct(private string $responseMessage)
    {
        parent::__construct($responseMessage);
        $this->statusCode = 404;
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