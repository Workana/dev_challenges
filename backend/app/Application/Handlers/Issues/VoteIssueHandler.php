<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\VoteIssueCommand;
use App\Application\Services\CurrentUserService;
use App\Application\Services\PusherService;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\model\Enums\IssueStatuses;
use App\model\Enums\UserIssueStatuses;
use DomainException;

class VoteIssueHandler
{
    public function __construct(
        private CurrentUserService $currentUserService,
        private PredisIssueRepository $issueRepository,
        private PusherService $pusher
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
        $this->pusher->triggerData(
            strval($issue->getNumber()),
            'user-voted',
            $issue->toArray()
        );
    }
}