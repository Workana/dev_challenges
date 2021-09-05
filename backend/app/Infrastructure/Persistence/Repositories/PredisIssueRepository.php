<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\model\Entities\Issue;
use App\model\Entities\User;
use App\model\Repositories\IssueRepository;
use Predis\Client;

class PredisIssueRepository implements IssueRepository
{
    private Client $client;
    private const KEY_NAME = 'issues';

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
        ]);
    }

    public function findByNumber(int $number): ?Issue
    {
        $exists = $this->client->exists($number);
        if ($exists) {
            $issue = json_decode($this->client->get($number));
            return new Issue(
                $issue->number,
                $issue->users,
                $issue->userStatuses,
                $issue->status
            );
        }
        return null;
    }

    public function save(Issue $issue): void
    {
        $this->client->set($issue->getNumber(), json_encode($issue->toArray()));
    }
}