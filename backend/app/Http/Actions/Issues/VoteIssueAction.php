<?php

declare(strict_types=1);

namespace App\Http\Actions\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Exceptions\InvalidBodyException;
use App\Application\Handlers\Issues\VoteIssueHandler;
use App\Domain\Entities\Issue;
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
        if (key_exists(self::ISSUE_PARAM, $args)) {
            $number = $args[self::ISSUE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        if (!$number) {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        $body = $request->getParsedBody();
        
        if ($body && key_exists(self::VOTE_PARAM, $body)) {
            $vote = $body[self::VOTE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::VOTE_PARAM);
        }
        
        if (!$vote) {
            throw new InvalidBodyException('Missing argument: ' . self::VOTE_PARAM);
        }

        if ($vote !== Issue::VOTE_PASSED) {
            $vote = (int) $vote;
        }

        $this->handler->handle(
            new VoteIssueCommand(
                (int) $number,
                $vote
            )
        );
        return $response;
    }
}