<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\User;
interface UserRepository
{
    public function findByName(string $name): ?User;
    public function save(User $user): void;
}