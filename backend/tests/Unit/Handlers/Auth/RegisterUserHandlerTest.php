<?php 

declare(strict_types=1);

namespace Tests\Unit\Application\Handlers\Auth;

use App\Application\Commands\Auth\RegisterUserCommand;
use App\Application\Handlers\Auth\RegisterUserHandler;
use App\Infrastructure\Persistence\MockRepositories\MockUserRepository;
use DomainException;
use Firebase\JWT\JWT;
use PHPUnit\Framework\TestCase;

final class RegisterUserHandlerTest extends TestCase
{
    private RegisterUserHandler $sut;

    public function initialize()
    {
        $this->sut = new RegisterUserHandler(
            new MockUserRepository()
        );
    }

    public function testCanRegisterValidUser(): void
    {
        $this->initialize();

        $command = new RegisterUserCommand(
            'David'
        );
        
        $result = $this->sut->handle($command);

        $decodedToken = JWT::decode($result, getenv('JWT_SECRET'), array_keys(JWT::$supported_algs));

        $this->assertEquals('David', $decodedToken->username);
    }

    public function testCanNotRegisterExistingUser(): void
    {
        $this->initialize();
        
        $command = new RegisterUserCommand(
            'Agos'
        );
        
        $this->expectException(DomainException::class);
        
        $this->sut->handle($command);
    }
}


