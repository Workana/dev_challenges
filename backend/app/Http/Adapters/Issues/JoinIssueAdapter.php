<?php

declare(strict_types=1);

namespace App\Http\Adapters\Issues;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Exceptions\InvalidBodyException;

class JoinIssueAdapter
{
    private const ISSUE_PARAM = 'issue';
    public function __construct(
    ) { }
    
    public function adapt(array $args): JoinIssueCommand
    {
        if (key_exists(self::ISSUE_PARAM, $args)) {
            $number = $args[self::ISSUE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }
        
        if (!$number) {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        return new JoinIssueCommand(
            (int) $number
        );
    }
}