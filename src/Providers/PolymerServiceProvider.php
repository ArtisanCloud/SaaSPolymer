<?php
declare(strict_types=1);

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

        $this->loadRoutesFrom(__DIR__ . '/../../routes/web.php');
        $this->loadRoutesFrom(__DIR__ . '/../../routes/api.php');
        $this->loadViewsFrom(__DIR__ . '/../../resources/views', 'artisan-cloud');

        if ($this->app->runningInConsole()) {

//            $this->commands([
//                SaaSPolymerInstallCommand::class,
//            ]);

            $this->publishes([
                __DIR__ . '/../../config/polymer.php' => "/../" . config_path('artisancloud/polymer.php'),
            ], ['SaaSPolymer', 'Landlord-Config']);

            if (!class_exists('CreateArtisansTable')) {
                $this->publishes([
                    __DIR__ . '/../Services/ArtisanService/database/migrations/create_artisans_table.php' => database_path('migrations/2020_08_01_000050_create_artisans_table.php'),
                    // you can add any number of migrations here
                ], ['ArtisanCloud', 'SaaSPolymer', 'Artisan']);
            }
        }
    }
}
