<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Domain\Entities\User;
use RuntimeException;

final class CurrentUserService
{
    private ?User $user = null;

    public function __construct(){}

    public function getUser(): User
    {
        if ($this->user) {
            return $this->user;
        }
        throw new RuntimeException('Current user is null');
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}