<?php

namespace App\model\Enums;

use PhpParser\Node\Stmt\Enum_;

class IssueStatuses extends Enum_
{
    public const VOTING = 'Voting';
    public const FINISHED = 'Finished';
}
