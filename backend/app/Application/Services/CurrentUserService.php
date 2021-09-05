<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\model\Entities\User;

final class CurrentUserService
{
    private User $user;

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}