<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Handlers\Issues\VoteIssueHandler;
use App\Http\Adapters\Issues\VoteIssueAdapter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class VoteIssueAction
{
    public function __construct(
        private VoteIssueAdapter $adapter,
        private VoteIssueHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $command = $this->adapter->adapt($request, $args);
        $this->handler->handle($command);
        return $response;
    }
}