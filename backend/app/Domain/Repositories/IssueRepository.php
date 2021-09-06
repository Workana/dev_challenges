<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\Issue;

interface IssueRepository
{
    public function findByNumber(int $number): ?Issue;
    public function save(Issue $issue): void;
}