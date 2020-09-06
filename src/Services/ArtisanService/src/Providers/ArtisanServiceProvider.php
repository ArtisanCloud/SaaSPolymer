<?php

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Providers;

use Illuminate\Support\ServiceProvider;
use ArtisanCloud\SaaSFramework\Services\ArtisanService\src\Contracts\ArtisanServiceContract;
use ArtisanCloud\SaaSFramework\Services\ArtisanService\src\ArtisanService;
use Laravel\Passport\Passport;

/**
 * Class ArtisanServiceProvider
 * @package App\Providers
 */
class ArtisanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->register(ArtisanServiceProvider::class);

        $this->app->bind(
            ArtisanServiceContract::class,
            ArtisanService::class
        );
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
              // publish config file
              $this->publishes([
                  __DIR__ . '/../../config/artisan.php' => "/../" . config_path('artisancloud/artisan.php'),
              ], ['SaaSFramework', 'Artisan-Config']);
            }

    }
}
