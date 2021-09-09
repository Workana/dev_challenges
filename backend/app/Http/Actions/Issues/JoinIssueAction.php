<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Handlers\Issues\JoinIssueHandler;
use Assert\Assertion;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class JoinIssueAction
{
    private const ISSUE_PARAM = 'issue';
    
    public function __construct(
        private JoinIssueHandler $handler,
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        Assertion::keyExists($args, self::ISSUE_PARAM);
        Assertion::notNull($args[self::ISSUE_PARAM]);
        Assertion::integerish($args[self::ISSUE_PARAM]);

        $this->handler->handle(new JoinIssueCommand(
                (int) $args[self::ISSUE_PARAM]
            )
        );
        
        return $response;
    }
}