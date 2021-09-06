<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\Application\Exceptions\DuplicateEntityException;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use Predis\Client;

class PredisUserRepository implements UserRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => $_ENV['REDIS_SCHEME'],
            'host'   => $_ENV['REDIS_HOST'],
            'port'   => $_ENV['REDIS_PORT'],
        ]);
    }

    public function findByName(string $name): ?User
    {
        $users = $this->client->get('users');
        if ($users) {
            $users =json_decode($users);
                if (!in_array($name, $users)){
                    return null;
                }
        }
        return new User($name);
    }

    public function save(User $user): void
    {
        $users = $this->client->get('users');
        if ($users) {
            $users =json_decode($users);
            if (in_array($user->getName(), $users)){
                throw new DuplicateEntityException('Name already on database');
            }
        } else {
            $users = [];
        }
        $users[] = $user->getName();
        $this->client->set('users', json_encode($users));
    }
}