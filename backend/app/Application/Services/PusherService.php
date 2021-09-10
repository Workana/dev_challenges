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
            getenv('PUSHER_KEY'),
            getenv('PUSHER_SECRET'),
            getenv('PUSHER_APP_ID'),
            [
                'cluster' => getenv('PUSHER_CLUSTER'),
                'useTLS' => getenv('PUSHER_USE_TLS')
            ]
        );
    }

    public function pushEvent(string $channel = 'default', string $event = 'default', array $data = []): void
    {
        $this->pusher->trigger($channel, $event, $data);
    }
}
