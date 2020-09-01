<?php

namespace ArtisanCloud\SaaSPolymer\Providers;

use Laravel\Passport\Passport;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\ServiceProvider;

/**
 * Class PolymerServiceProvider
 * @package ArtisanCloud\SaaSPolymer\Providers
 */
class PolymerServiceProvider extends ServiceProvider
{

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
//        $this->app->register(
//            TenantServiceProvider::class
//        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // make sure passport is installed
        Passport::routes(function ($router) {
            // RouteRegistrar->forAccessTokens()
            $router->forAccessTokens();
        }, ['middleware' => 'checkHeader']);
        Passport::tokensExpireIn(now()->addDays(90));
        Passport::refreshTokensExpireIn(now()->addDays(90));



        if ($this->app->runningInConsole()) {

//            $this->commands([
//                SaasPolymerInstallCommand::class,
//            ]);

            $this->publishes([
                __DIR__ . '/../../config/polymer.php' => "/../" . config_path('artisancloud/polymer.php'),
            ], ['SaaSPolymer', 'Landlord-Config']);
        }
    }
}
