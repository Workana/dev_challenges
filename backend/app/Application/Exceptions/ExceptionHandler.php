<?php

declare(strict_types=1);

namespace App\Application\Exceptions;

use Psr\Http\Message\ResponseInterface as Response;
use Slim\Handlers\ErrorHandler;

class ExceptionHandler extends ErrorHandler
{
    public function respond() : Response
    {
        $exception = $this->exception;
        if ($exception instanceof DuplicateEntityException) {
            return $this->createErrorResponse($exception->getStatusCode() ?: 403, $exception->getMessage() ?: 'Duplicated entity exception');
        }

        if ($exception instanceof EntityNotFoundException) {
            return $this->createErrorResponse($exception->getStatusCode() ?: 404, $exception->getMessage() ?: 'Entity no found exception');
        }


        if ($exception instanceof InvalidBodyException) {
            return $this->createErrorResponse($exception->getStatusCode() ?: 422, $exception->getMessage() ?: 'Invalid body exception');
        }


        if ($exception instanceof UnauthorizedException) {
            return $this->createErrorResponse($exception->getStatusCode() ?: 401, $exception->getMessage() ?: 'Unauthorized exception');
        }

        return $this->createErrorResponse();
    }

    private function createErrorResponse(?int $statusCode=500, ?string $message = 'Woops, something went whrong!'): Response
    {
        $response = $this->responseFactory->createResponse($statusCode);
        $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(
            json_encode(
                [
                    'status' => $statusCode,
                    'payload' => $message
                ]
            )
        );
        return $response;
    }
 }