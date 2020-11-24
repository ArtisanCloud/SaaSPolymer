<?php

namespace ArtisanCloud\SaaSPolymer\Listeners;

use ArtisanCloud\SaaSMonomer\Services\TenantService\src\Models\Tenant;
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
    public function handleUserRegistered($event)
    {
        Log::info('Subscriber user registered: ' . $event->user->mobile);

        // create org for user
        $orgService = 
        $org = $orgService->createBy([
            'user_uuid' => $user->uuid,
            'name' => $arrayData['org_name'],
        ]);
//                dd($org);
        
        // create a tenant for org
        $arrayDBInfo = $tenantService->generateDatabaseAccessInfoBy(Tenant::TYPE_USER, $artisan->short_name, $org->uuid);
        $arrayDBInfo['org_uuid'] = $org->uuid;
        $tenant = $tenantService->createBy($arrayDBInfo);



        // dispatch create tenant database job
        $user = $event->user;
        $user->loadMissing('tenant');
        $personTenant = $user->tenant;
        Log::info('Ready to dispatch user tenant: ' . $personTenant->uuid);
//        dd($personTenant);
        ProcessTenantDatabase::dispatch($personTenant)
            ->onConnection('redis-tenant')
            ->onQueue('tenant-database');

    }

    /**
     * Handle user logout events.
     */
    public function handleUserLogout($event)
    {
    }


    /**
     * Handle a job failure.
     *
     * @param  $event
     * @param \Throwable $exception
     * @return void
     */
    public function failed($event, $exception)
    {
        //
    }


    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
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
