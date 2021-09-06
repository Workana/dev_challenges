<?php

declare(strict_types=1);

namespace App\Http\Adapters\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Exceptions\InvalidBodyException;
use Psr\Http\Message\ServerRequestInterface as Request;

class VoteIssueAdapter
{
    private const ISSUE_PARAM = 'issue';
    private const VOTE_PARAM = 'vote';
    public function __construct(
    ) { }
    
    public function adapt(Request $request, array $args): VoteIssueCommand
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
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        return new VoteIssueCommand(
            (int) $number,
            (int) $vote
        );
    }
}