<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\UserIssueStatuses;
use Assert\Assertion;
use DomainException;

class Issue
{
    public const VOTE_PASSED = '?';

    public function __construct(
        private int $number,
        private array $joinedUsers,
        private array $userStatuses,
        private string $status,
        private ?float $avg = null
    ) {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getUsers(): array
    {
        return $this->joinedUsers;
    }

    public function addUser(User $user): void
    {
        Assertion::notInArray($user->getName(), $this->joinedUsers, "User already joined on issue number $this->number");

        $this->joinedUsers[] = $user->getName();
        $this->userStatuses[] = [
            'user' => $user->getName(),
            'status' => UserIssueStatuses::WAITING,
            'vote' => null
        ];
    }

    public function getUserStatuses(): array
    {
        return $this->userStatuses;
    }

    public function setUserStatuses(array $userStatuses): void
    {
        $this->userStatuses = $userStatuses;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function toArray(): array
    {
        $result = [
            'number' => $this->getNumber(),
            'users' => $this->getUsers(),
            'userStatuses' => $this->getUserStatuses(),
            'status' => $this->getStatus(),
        ];
        
        if ($this->avg) {
            $result['avg'] = number_format($this->avg, 2);
        }
        
        return $result;
    }

    public function calculateAvg(): void
    {
        $votes = 0;
        $voters = 0;
        foreach ($this->userStatuses as $userStatuses) {
            if ($userStatuses['status'] !== UserIssueStatuses::PASSED) {
                $voters++;
                $votes += $userStatuses['vote'];
            }
        }

        if ($voters !== 0) {
            $this->avg = $votes / $voters;       
        } else {
            $this->avg = 0;
        }
    }
}