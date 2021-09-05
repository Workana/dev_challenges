<?php

declare(strict_types=1);

namespace App\Application\Commands\Issues;

class GetIssueQuery
{   
    public function __construct(
        private int $number
    ) { }

    public function getNumber(): int
    {
        return $this->number;
    }
}