<?php

namespace App\Events\User\Deposit;

use App\Models\DepositReceipt;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedStatusDeposit
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public DepositReceipt $transactionData;
    /**
     * Create a new event instance.
     */
    public function __construct(
        DepositReceipt $transactionData
    )
    {
       $this->transactionData = $transactionData;
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
