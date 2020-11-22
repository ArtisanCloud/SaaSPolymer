<?php

namespace ArtisanCloud\SaaSPolymer\Listeners;

use ArtisanCloud\SaaSPolymer\Events\UserRegistered;
use ArtisanCloud\SaaSPolymer\Jobs\ProcessTenantDatabase;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UserEventSubscriber
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle user login events.
     */
    public function handleUserRegistered($event) {
        Log::info('Subscriber user registered: '. $event->user->mobile);

        // dispatch create tenant database job
        ProcessTenantDatabase::dispatch($event->user);
//            ->onConnection('tenant')
//            ->onQueue('database');

    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event) {}



    /**
     * Handle a job failure.
     *
     * @param  $event
     * @param  \Throwable  $exception
     * @return void
     */
    public function failed($event, $exception)
    {
        //
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return void
     */
    public function subscribe($events)
    {
        $events->listen(
            UserRegistered::class,
            [UserEventSubscriber::class, 'handleUserRegistered']
        );

//        $events->listen(
//            'Illuminate\Auth\Events\Logout',
//            [UserEventSubscriber::class, 'handleUserLogout']
//        );
    }
}
