<?php

declare(strict_types=1);

namespace App\model\Repositories;

use App\model\Entities\Issue;

interface IssueRepository
{
    public function findByNumber(int $number): ?Issue;
    public function save(Issue $issue): void;
}