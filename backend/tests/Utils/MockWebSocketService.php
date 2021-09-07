<?php

declare(strict_types=1);

namespace Tests\Utils;

use App\Application\Interfaces\WebSocketService;

class MockWebSocketService implements WebSocketService
{
    public function __construct()
    {
    }

    public function pushEvent(string $channel = 'default', string $event = 'default', array $data = []): void
    {
    }
}