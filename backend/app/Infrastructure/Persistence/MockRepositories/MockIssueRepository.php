<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MockRepositories;

use App\Domain\Entities\Issue;
use App\Domain\Repositories\IssueRepository;

class MockIssueRepository implements IssueRepository
{
    public function findByNumber(int $number): ?Issue
    {
        return null;
    }

    public function save(Issue $issue): void
    {
    }
}