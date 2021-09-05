<?php

declare(strict_types=1);

namespace App\model\Repositories;

use App\model\Entities\User;

interface UserRepository
{
    public function findByName(string $name): ?User;
    public function save(User $user): void;
}