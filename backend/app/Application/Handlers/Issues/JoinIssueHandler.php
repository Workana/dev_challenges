<?php

declare(strict_types=1);

namespace App\Application\Handlers\Issues;

use App\Application\Commands\Issues\JoinIssueCommand;
use App\Application\Interfaces\WebSocketService;
use App\Application\Services\CurrentUserService;
use App\Domain\Entities\Issue;
use App\Domain\Enums\IssueStatuses;
use App\Domain\Enums\UserIssueStatuses;
use App\Domain\Repositories\IssueRepository;

class JoinIssueHandler
{
    public function __construct(
        private CurrentUserService $currentUserService,
        private IssueRepository $issueRepository,
        private WebSocketService $webSocketService
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
        $this->webSocketService->pushEvent(
            strval($issue->getNumber()),
            'user-joined',
            $issue->toArray()
        );
    }
}