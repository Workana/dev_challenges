<?php

declare(strict_types=1);

namespace App\Http\Adapters\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Application\Exceptions\InvalidBodyException;

class GetIssueAdapter
{
    private const ISSUE_PARAM = 'issue';
    public function __construct(
    ) { }
    
    public function adapt(array $args): GetIssueQuery
    {
        if (key_exists(self::ISSUE_PARAM, $args)) {
            $number = $args[self::ISSUE_PARAM] ?: null;
        } else {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }
        
        if (!$number) {
            throw new InvalidBodyException('Missing argument: ' . self::ISSUE_PARAM);
        }

        return new GetIssueQuery(
            (int) $number
        );
    }
}