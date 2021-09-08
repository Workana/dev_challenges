<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Application\Exceptions\InvalidBodyException;
use App\Application\Handlers\Issues\GetIssueHandler;
use App\Http\Actions\BaseAction;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class GetIssueAction extends BaseAction
{
    private const ISSUE_PARAM = 'issue';
    
    public function __construct(
        private GetIssueHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        if (key_exists(self::ISSUE_PARAM, $args)) {
            $number = $args[self::ISSUE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }
        
        if (!$number) {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        $result = $this->handler->handle(
            new GetIssueQuery(
                (int) $number
            )
        );
        if (!$result) {
            return $this->respondWithData($response, 'Issue not found');
        }

        return $this->respondWithArray($response, $result->toArray());
    }
}