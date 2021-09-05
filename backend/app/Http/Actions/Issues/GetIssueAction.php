<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Handlers\Issues\GetIssueHandler;
use App\Http\Actions\BaseAction;
use App\Http\Adapters\Issues\GetIssueAdapter;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetIssueAction extends BaseAction
{
    public function __construct(
        private GetIssueAdapter $adapter,
        private GetIssueHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        $query = $this->adapter->adapt($args);
        $result = $this->handler->handle($query);
        if (!$result) {
            return $this->respondWithData($response, 'Issue not found');
        }

        return $this->respondWithArray($response, $result->toArray());
    }
}