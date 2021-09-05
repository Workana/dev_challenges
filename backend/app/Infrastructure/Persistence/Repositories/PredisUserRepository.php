<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Repositories;

use App\model\Entities\User;
use App\model\Repositories\UserRepository;
use Predis\Client;

class PredisUserRepository implements UserRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
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
                throw new \Exception('Name already on database');
            }
        } else {
            $users = [];
        }
        $users[] = $user->getName();
        $this->client->set('users', json_encode($users));
    }
}