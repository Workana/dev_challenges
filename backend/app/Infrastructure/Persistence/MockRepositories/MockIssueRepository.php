<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MockRepositories;

use App\Domain\Entities\Issue;
use App\Domain\Repositories\IssueRepository;

class MockIssueRepository implements IssueRepository
{
    public function findByNumber(int $number): ?Issue
    {
        if ($number === 1) {
            return new Issue(
                1,
                [
                    'David',
                    'Agos'
                ],
                [
                    [
                        'user' => 'David',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Waiting',
                        'vote' => null
                    ]
                ],
                'Voting'
            );
        }
        if ($number === 2) {
            return new Issue(
                2,
                [
                    'David',
                    'Agos'
                ],
                [
                    [
                        'user' => 'David',
                        'status' => 'Voted',
                        'vote' => 8
                    ],
                    [
                        'user' => 'Agos',
                        'status' => 'Voted',
                        'vote' => 5
                    ]
                ],
                'Finished',
                6.5
            );
        }
        return null;
    }

    public function save(Issue $issue): void
    {
    }
}