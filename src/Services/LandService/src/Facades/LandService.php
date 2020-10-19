<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSMonomer\Services\LandService\src\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class LandService
 * @package ArtisanCloud\SaaSMonomer\Services\LandService\src
 */
class LandService extends Facade
{
    //
    protected static function getFacadeAccessor()
    {
        return LandService::class;
    }
}
