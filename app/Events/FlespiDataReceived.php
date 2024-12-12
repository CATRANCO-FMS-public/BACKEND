<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FlespiDataReceived implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $tracker_data;

    /**
     * Create a new event instance.
     *
     * @param array $trackerData
     */
    public function __construct(array $trackerData)
    {
        // Assign the tracker data for easier access in the frontend
        $this->tracker_data = $trackerData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('flespi-data');  // Public channel for broadcasting
    }

    /**
     * Get the data to broadcast to the frontend.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return $this->tracker_data;
    }
}
