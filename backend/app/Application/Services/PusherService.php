<?php
declare(strict_types=1);

namespace App\Application\Services;

use App\Application\Interfaces\WebSocketService;
use Pusher\Pusher;

class PusherService implements WebSocketService
{
    private Pusher $pusher;

    public function __construct()
    {
        $this->pusher = new Pusher(
            $_ENV['PUSHER_KEY'],
            $_ENV['PUSHER_SECRET'],
            $_ENV['PUSHER_APP_ID'],
            [
                'cluster' => $_ENV['PUSHER_CLUSTER'],
                'useTLS' => true
            ]
        );
    }

    public function pushEvent(string $channel = 'default', string $event = 'default', array $data = []): void
    {
        $this->pusher->trigger($channel, $event, $data);
    }
}