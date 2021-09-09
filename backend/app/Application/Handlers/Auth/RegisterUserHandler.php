<?php

declare(strict_types=1);

namespace App\Application\Handlers\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use DomainException;
use Firebase\JWT\JWT;

class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository
    ) { }
    
    public function handle(RegisterUserCommand $command): string
    {     
        if ($this->userRepository->findByName($command->getName())){
            throw new DomainException('User with the same name already exists on database', 403);
        }
        $user = new User($command->getName());
        $this->userRepository->save($user);
    
        $jwt = JWT::encode([
            'username' => $user->getName(),
            'created_at' => date('U')
        ], getenv('JWT_SECRET'));

        return $jwt;
    }
}