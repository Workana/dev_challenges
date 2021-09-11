<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Application\Handlers\Issues\GetIssueHandler;
use App\Http\Actions\BaseAction;
use Assert\Assertion;
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
        Assertion::keyExists($args, self::ISSUE_PARAM);
        Assertion::notNull($args[self::ISSUE_PARAM]);
        Assertion::integerish($args[self::ISSUE_PARAM]);

        $result = $this->handler->handle(
            new GetIssueQuery(
                (int) $args[self::ISSUE_PARAM]
            )
        );

        return $this->respondWithArray($response, $result->toArray());
    }
}