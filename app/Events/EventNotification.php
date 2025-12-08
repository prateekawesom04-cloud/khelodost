<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class EventNotification
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $eventData;

    /**
     * Create a new event instance.
     */
    public function __construct($eventData)
    {
        //
        $this->eventData = $eventData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // return [
        //     new Channel('eventData'),
        // ];

        return new Channel('eventData');
    }

    public function broadcastAs()
    {
        return 'eventDataListener';
    }
    
    public function broadcastWith(): array
    {
        return [
            'eventData' => $this->eventData
        ];
    }
}
