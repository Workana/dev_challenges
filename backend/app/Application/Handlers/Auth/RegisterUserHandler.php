<?php

declare(strict_types=1);

namespace App\Application\Handlers\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Infrastructure\Persistence\Repositories\PredisUserRepository;
use App\model\Entities\User;
use App\Model\Repositories\UserRepository;
use Firebase\JWT\JWT;

class RegisterUserHandler
{
    public function __construct(
        // private UserRepository $userRepository
        private PredisUserRepository $userRepository
    ) { }
    
    public function handle(RegisterUserCommand $command): string
    {
        // if ($this->userRepository->findByName($command->getName())) {
        //     throw new DomainException();//todo ya te escribo
        // }
        
        $user = new User($command->getName());
        $this->userRepository->save($user);
    
        $jwt = JWT::encode([
            'username' => $user->getName(),
            'created_at' => date('U')
        ], $_ENV['JWT_SECRET']);

        return $jwt;
    }
}