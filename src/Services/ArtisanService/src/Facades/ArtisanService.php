<?php

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class ArtisanService
 * @package ArtisanCloud\SaaSFramework\Services\ArtisanService\src
 */
class ArtisanService extends Facade
{
    //
    protected static function getFacadeAccessor()
    {
        return ArtisanService::class;
    }
}
