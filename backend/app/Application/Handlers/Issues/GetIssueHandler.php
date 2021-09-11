<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\GetIssueQuery;
use App\Application\Exceptions\EntityNotFoundException;
use App\Domain\Entities\Issue;
use App\Domain\Enums\IssueStatuses;
use App\Domain\Enums\UserIssueStatuses;
use App\Domain\Repositories\IssueRepository;

class GetIssueHandler
{
    public function __construct(
        private IssueRepository $issueRepository
    ) { }
    
    public function handle(GetIssueQuery $query): ?Issue
    {
        $issue = $this->issueRepository->findByNumber($query->getNumber());

        if (!$issue) {
            $number = $query->getNumber();
            throw new EntityNotFoundException("Issue with number $number does not exist");
        }

        if ($issue->getStatus() !== IssueStatuses::FINISHED) {
            $currentUserStatus = [];
            foreach ($issue->getUserStatuses() as $userStatuses) {
                if ($userStatuses['status'] !== UserIssueStatuses::PASSED){
                    unset($userStatuses['vote']);
                }
                $currentUserStatus[] = $userStatuses;
            }
            
            $issue->setUserStatuses($currentUserStatus);
        }

        return $issue;
    }
}