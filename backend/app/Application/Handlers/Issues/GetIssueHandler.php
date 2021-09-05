<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\model\Entities\Issue;

class GetIssueHandler
{
    public function __construct(
        private PredisIssueRepository $issueRepository
    ) { }
    
    public function handle(GetIssueQuery $query): ?Issue
    {
        return $this->issueRepository->findByNumber($query->getNumber());
    }
}