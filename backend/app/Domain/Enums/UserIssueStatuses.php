<?php

namespace App\Domain\Enums;

use PhpParser\Node\Stmt\Enum_;

class UserIssueStatuses extends Enum_
{
    public const WAITING = 'Waiting';
    public const VOTED = 'Voted';
    public const PASSED = 'Passed';
}
