<?php

namespace App\Events\Client;

use App\Models\AccessToken;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class InviteClientEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $access;
    /**
     * Create a new event instance.
     */
    public function __construct(
        AccessToken $access

    )
    {
        Log::info('disparo de event '.__CLASS__);
        $this->access = $access;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
