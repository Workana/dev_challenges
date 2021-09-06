<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\model\Entities\Issue;
use App\model\Enums\IssueStatuses;

class GetIssueHandler
{
    public function __construct(
        private PredisIssueRepository $issueRepository
    ) { }
    
    public function handle(GetIssueQuery $query): ?Issue
    {
        $issue = $this->issueRepository->findByNumber($query->getNumber());
        if ($issue && $issue->getStatus() !== IssueStatuses::FINISHED) {
            foreach ($issue->getUserStatuses() as $userStatuses) {
                unset($userStatuses->vote);
            }
        }

        return $issue;
    }
}