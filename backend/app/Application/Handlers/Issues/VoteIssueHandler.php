<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Interfaces\WebSocketService;
use App\Application\Services\CurrentUserService;
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
    
    public function handle(VoteIssueCommand $command): void
    {
        $issue = $this->issueRepository->findByNumber($command->getNumber());

        if (!$issue) {
            $number = $command->getNumber();
            throw new DomainException("Issue $number not found");
        }
        
        $everyOneVoted = true;
        foreach ($issue->getUserStatuses() as $userStatuses){
            if ($userStatuses->user === $this->currentUserService->getUser()->getName()) {
                $userStatuses->status = UserIssueStatuses::VOTED;
                $userStatuses->vote = $command->getVote();
            }
            if ($userStatuses->status !== UserIssueStatuses::VOTED) {
                $everyOneVoted = false;
            }
        }

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
    }
}