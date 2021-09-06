<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Domain\Entities\Issue;
use App\Domain\Enums\IssueStatuses;
use App\Domain\Repositories\IssueRepository;

class GetIssueHandler
{
    public function __construct(
        private IssueRepository $issueRepository
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