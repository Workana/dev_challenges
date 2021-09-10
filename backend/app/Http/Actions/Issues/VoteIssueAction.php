<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Handlers\Issues\VoteIssueHandler;
use App\Domain\Entities\Issue;
use Assert\Assertion;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class VoteIssueAction
{
    private const ISSUE_PARAM = 'issue';
    private const VOTE_PARAM = 'vote';

    public function __construct(
        private VoteIssueHandler $handler
    ) { }
    
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        Assertion::keyExists($args, self::ISSUE_PARAM);
        Assertion::notNull($args[self::ISSUE_PARAM]);
        Assertion::integerish($args[self::ISSUE_PARAM]);
        
        $body = $request->getParsedBody();
        
        Assertion::keyExists($body, self::VOTE_PARAM);
        Assertion::notNull($body[self::VOTE_PARAM]);
        
        if ($body[self::VOTE_PARAM] !== Issue::VOTE_PASSED) {
            Assertion::integerish($body[self::VOTE_PARAM]);
            $vote = (int) $body[self::VOTE_PARAM];
        } else {
            $vote = $body[self::VOTE_PARAM];
        }

        $this->handler->handle(
            new VoteIssueCommand(
                (int) $args[self::ISSUE_PARAM],
                $vote
            )
        );
        
        return $response;
    }
}