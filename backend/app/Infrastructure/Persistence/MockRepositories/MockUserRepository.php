<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\MockRepositories;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class MockUserRepository implements UserRepository
{
    public function __construct()
    {
    }

    public function findByName(string $name): ?User
    {
        if ($name === 'Agos') {
            return new User('Agos');
        }
        return null;
    }

    public function save(User $user): void
    {
    }
}