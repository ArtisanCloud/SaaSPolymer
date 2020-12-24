<?php

namespace ArtisanCloud\SaaSPolymer\Events;

use App\Models\User;
use ArtisanCloud\UBT\Facades\UBT;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserRegistered
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public User $user;
    public string $orgName;
    public string $shortName;

    /**
     * Create a new event instance.
     *
     * @param User $user
     * @param string $orgName
     * @param string $shortName
     *
     * @return void
     */
    public function __construct(User $user, string $orgName, string $shortName)
    {
        //
        $this->user = $user;
        $this->orgName = $orgName;
        $this->shortName = $shortName;
        UBT::info("Event user registered", [
            'mobile' => $user->mobile,
            'orgNane' => $orgName,
            'shortName' => $shortName,

        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
