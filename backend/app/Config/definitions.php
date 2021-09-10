<?php

declare(strict_types=1);

use function DI\create;
use App\Application\Interfaces\WebSocketService;
use App\Application\Services\PusherService;
use App\Domain\Repositories\IssueRepository;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\Persistence\Repositories\PredisIssueRepository;
use App\Infrastructure\Persistence\Repositories\PredisUserRepository;

return [
    IssueRepository::class => create(PredisIssueRepository::class),
    UserRepository::class => create(PredisUserRepository::class),
    WebSocketService::class => create(PusherService::class)
];