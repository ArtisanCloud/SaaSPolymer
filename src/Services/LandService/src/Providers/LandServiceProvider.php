<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Services\LandService\src\Providers;

use Illuminate\Support\ServiceProvider;
use ArtisanCloud\SaaSMonomer\Services\LandService\src\Contracts\LandServiceContract;
use ArtisanCloud\SaaSMonomer\Services\LandService\src\LandService;

/**
 * Class LandServiceProvider
 * @package App\Providers
 */
class LandServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->bind(
            LandServiceContract::class,
            LandService::class
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
              // publish config file
              $this->publishes([
                  __DIR__ . '/../../config/land.php' => "/../" . config_path('artisancloud/land.php'),
              ], ['SaaSMonomer', 'Land-Config']);


              // register artisan command
              if (! class_exists('CreateLandTable')) {
                $this->publishes([
                  __DIR__ . '/../../database/migrations/create_lands_table.php' => database_path('migrations/0_0_0_0_create_lands_table.php'),
                  // you can add any number of migrations here
                ], ['ArtisanCloud','SaaSMonomer', 'Land-Migration']);
              }
            }

    }
}
