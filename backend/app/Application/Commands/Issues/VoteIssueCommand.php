<?php

declare(strict_types=1);

namespace App\Application\Commands\Issues;

class VoteIssueCommand
{   
    public function __construct(
        private int $number,
        private int $vote,
    ) { }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getVote(): int
    {
        return $this->vote;
    }
}