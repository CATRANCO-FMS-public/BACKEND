<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class FlespiDataReceived implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $tracker_ident;
    public $location;
    public $timestamp;
    public $dispatch_log;

    /**
     * Create a new event instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        // Assign the data values for easier access in the frontend
        $this->tracker_ident = $data['tracker_ident'] ?? null;
        $this->location = $data['location'] ?? null;  // Contains latitude, longitude, and speed
        $this->timestamp = $data['timestamp'] ?? null;
        $this->dispatch_log = $data['dispatch_log'] ?? null;  // Contains the related dispatch log
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
        return [
            'tracker_ident' => $this->tracker_ident,
            'location' => $this->location,
            'timestamp' => $this->timestamp,
            'dispatch_log' => $this->dispatch_log,  // Send dispatch log data for sync with map
        ];
    }
}
