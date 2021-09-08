<?php

declare(strict_types=1);

use DI\Container;
use App\Application\Interfaces\WebSocketService;
use App\Application\Services\PusherService;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\Infrastructure\Persistence\Repositories\PredisUserRepository;
use App\Domain\Repositories\IssueRepository;
use App\Domain\Repositories\UserRepository;
use Psr\Container\ContainerInterface;

return function (Container $container)
{
    $container->set('settings', function() {
        return [
            'name' => 'Workana Planning Poker',
            'displayErrorDetails' => true,
            'logErrorDetails' => true,
            'logErrors' => true,
        ];
    });
    $container->set(IssueRepository::class, function (ContainerInterface $container) {
        return new PredisIssueRepository();
    });
    $container->set(UserRepository::class, function (ContainerInterface $container) {
        return new PredisUserRepository();
    });
    $container->set(WebSocketService::class, function (ContainerInterface $container) {
        return new PusherService();
    });
};