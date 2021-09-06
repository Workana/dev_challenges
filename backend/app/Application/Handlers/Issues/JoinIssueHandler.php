<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Services\CurrentUserService;
use App\Application\Services\PusherService;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\model\Entities\Issue;
use App\model\Enums\IssueStatuses;
use App\model\Enums\UserIssueStatuses;

class JoinIssueHandler
{
    public function __construct(
        private CurrentUserService $currentUserService,
        private PredisIssueRepository $issueRepository,
        private PusherService $pusher
    ) { }
    
    public function handle(JoinIssueCommand $command): void
    {
        $issue = $this->issueRepository->findByNumber($command->getNumber());

        if (!$issue) {
            $issue = new Issue(
                $command->getNumber(),
                [
                    $this->currentUserService->getUser()->getName()
                ],
                [
                    [
                        'user' => $this->currentUserService->getUser()->getName(),
                        'status' => UserIssueStatuses::WAITING,
                        'vote' => null
                    ],
                ],
                IssueStatuses::VOTING
            );
        } else {
            if (!in_array($this->currentUserService->getUser()->getName(), $issue->getUsers())){
                $issue->addUser($this->currentUserService->getUser());
            }
        }
        $this->issueRepository->save($issue);

        //todo add to a queue
        $this->pusher->triggerData(
            strval($issue->getNumber()),
            'user-joined',
            $issue->toArray()
        );
    }
}