<?php

declare(strict_types=1);

namespace App\Application\Interfaces;

interface WebSocketService
{
    public function pushEvent(string $channel = 'default', string $event = 'default', array $data = []): void;
}