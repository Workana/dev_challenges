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
use DomainException;
use RuntimeException;

class JoinIssueHandler
{
    public function __construct(
        private CurrentUserService $currentUserService,
        private IssueRepository $issueRepository,
        private WebSocketService $webSocketService
    ) { }
    
    public function handle(JoinIssueCommand $command): ?Issue
    {
        $user = $this->currentUserService->getUser();

        if (!$user) {
            throw new RuntimeException('Current user not established', 409); 
        }

        $issue = $this->issueRepository->findByNumber($command->getNumber());

        if (!$issue) {
            $issue = new Issue(
                $command->getNumber(),
                [
                    $user->getName()
                ],
                [
                    [
                        'user' => $user->getName(),
                        'status' => UserIssueStatuses::WAITING,
                        'vote' => null
                    ],
                ],
                IssueStatuses::VOTING
            );
        } else {
            if ($issue->getStatus() === IssueStatuses::FINISHED) {
                $number = $issue->getNumber();
                throw new DomainException("Issue number $number is finished", 403);
            }

            $issue->addUser($user);
        }
        $this->issueRepository->save($issue);

        //todo add to a queue
        $this->webSocketService->pushEvent(
            strval($issue->getNumber()),
            'user-joined',
            $issue->toArray()
        );

        return $issue;
    }
}