<?php

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src;

use ArtisanCloud\SaaSFramework\Services\ArtisanService\src\Contracts\ArtisanServiceContract;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models\Artisan;

/**
 * Class ArtisanService
 * @package ArtisanCloud\SaaSFramework\Services\ArtisanService\src
 */
class ArtisanService implements ArtisanServiceContract
{
    //

    public function register($mobile)
    {
        $bResult = $this->isRegisteredByMobile($mobile);
        if(!$bResult){
            $bResult = $this->createArtisanByMobile($mobile);
        }
        return $bResult;
    }

    public function isRegisteredByMobile($mobile)
    {
        $bResult = Artisan::where('mobile',$mobile)
                    ->exists();
        return $bResult;
    }

    public function createArtisanByMobile($mobile){
        $artisan = new Artisan();

        $artisan->mobile = $mobile;

        $bResult = $artisan->save();
        return $bResult;
    }
}
