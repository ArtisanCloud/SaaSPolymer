<?php

namespace ArtisanCloud\SaaSPolymer\Jobs;

use App\Models\User;
use App\Services\UserService\UserService;
use ArtisanCloud\SaaSMonomer\Services\TenantService\src\TenantService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessTenantDatabase implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public User $user;
    protected TenantService $tenantService;
    protected UserService $userService;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        //
        $this->user = $user->withoutRelations();

        $this->tenantService = new TenantService();
        $this->userService = new UserService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        Log::info('Process Tenant database:' . $this->user->mobile);

        if ($this->userService->isUserInit($this->user)) {
            // create user database
            $arrayDBInfo = $this->tenantService->generateDatabaseAccessInfoBy($this->user->uuid);
            Log::debug('databaseID:', $arrayDBInfo);

            $bResult = $this->tenantService->createDatabase($arrayDBInfo);
            if (!$bResult) {
                Log::alert("User: {$this->user->mobile}  failed to create database, please email amdin");
            } else {
                Log::info("User: {$this->user->mobile}  succeed to create database, user will received a email to login");
            }

        } else {
            Log::warning('User is not init or user has create a tenant database');
        }

    }
}
