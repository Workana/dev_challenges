<?php

declare(strict_types=1);

namespace App\Http\Middlewares;

use App\Application\Exceptions\UnauthorizedException;
use App\Application\Services\CurrentUserService;
use App\Domain\Repositories\UserRepository;
use Firebase\JWT\JWT;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Server\RequestHandlerInterface;

class AuthenticateMiddleware
{
    public function __construct(
        private CurrentUserService $currentUser,
        private UserRepository $userRepository
    ) { }

    public function __invoke(Request $request, RequestHandlerInterface $handler) : Response
    {
        $token = $request->getHeader('Authorization');
        if ($token === []) {
            throw new UnauthorizedException();
        }

        $decodedToken = JWT::decode($token[0], getenv('JWT_SECRET'), array_keys(JWT::$supported_algs));

        try {
            $currentUser = $this->userRepository->findByName($decodedToken->username);
            if (!$currentUser) {
                throw new UnauthorizedException();
            }
        } catch (\Exception $error) {
            throw new UnauthorizedException();
        }
        
        $this->currentUser->setUser(
            $currentUser
        );
        $response = $handler->handle($request);

        return $response;
    }

}
