<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Interfaces\WebSocketService;
use App\Application\Services\CurrentUserService;
use App\Domain\Entities\Issue;
use App\Domain\Enums\IssueStatuses;
use App\Domain\Enums\UserIssueStatuses;
use App\Domain\Repositories\IssueRepository;
use DomainException;

class VoteIssueHandler
{
    public function __construct(
        private CurrentUserService $currentUserService,
        private IssueRepository $issueRepository,
        private WebSocketService $webSocketService
    ) { }
    
    public function handle(VoteIssueCommand $command): Issue
    {
        $issue = $this->issueRepository->findByNumber($command->getNumber());
        
        $number = $command->getNumber();
        if (!$issue) {    
            throw new DomainException("Issue $number not found");
        }
        
        $userName = $this->currentUserService->getUser()->getName();
        if (!in_array($this->currentUserService->getUser()->getName(), $issue->getUsers())) {
            throw new DomainException("User $userName not joined on issue number $number");
        }

        $everyOneVoted = true;
        $currentUserStatus = [];
        foreach ($issue->getUserStatuses() as $userStatuses){
            if ($userStatuses['user'] === $userName) {
                if ($command->getVote() === '?') {
                    $userStatuses['status'] = UserIssueStatuses::PASED;
                } else {
                    $userStatuses['status'] = UserIssueStatuses::VOTED;
                    $userStatuses['vote'] = $command->getVote();
                }
            }
            if ($userStatuses['status'] === UserIssueStatuses::WAITING) {
                $everyOneVoted = false;
            }
            $currentUserStatus[] = $userStatuses;
        }
        
        $issue->setUserStatuses($currentUserStatus);

        if (count($issue->getUsers()) > 0 && $everyOneVoted) {
            $issue->setStatus(IssueStatuses::FINISHED);
        }

        $this->issueRepository->save($issue);

        //todo add to a queue
        $this->webSocketService->pushEvent(
            strval($issue->getNumber()),
            'user-voted',
            $issue->toArray()
        );
        
        return $issue;
    }
}