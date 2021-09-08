<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Domain\Entities\Issue;
use App\Domain\Repositories\IssueRepository;
use Predis\Client;

class PredisIssueRepository implements IssueRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => getenv('REDIS_SCHEME'),
            'host'   => getenv('REDIS_HOST'),
            'port'   => getenv('REDIS_PORT'),
        ]);
    }

    public function findByNumber(int $number): ?Issue
    {
        $exists = $this->client->exists($number);
        if ($exists) {
            $issue = json_decode($this->client->get($number), true);
            if (key_exists('avg', $issue)) {
                $avg = (float) $issue['avg'];
            } else {
                $avg = null;
            }
            return new Issue(
                $issue['number'],
                $issue['users'],
                $issue['userStatuses'],
                $issue['status'],
                $avg
            );
        }
        return null;
    }

    public function save(Issue $issue): void
    {
        $this->client->set($issue->getNumber(), json_encode($issue->toArray()));
    }
}