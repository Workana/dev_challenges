<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Handlers\Issues\JoinIssueHandler;
use App\Http\Adapters\Issues\JoinIssueAdapter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class JoinIssueAction
{
    public function __construct(
        private JoinIssueAdapter $adapter,
        private JoinIssueHandler $handler,
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $command = $this->adapter->adapt($args);
        $this->handler->handle($command);
        return $response;
    }
}