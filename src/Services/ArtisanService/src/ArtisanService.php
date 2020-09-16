<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src;

use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models\Artisan;

/**
 * Class ArtisanService
 * @package ArtisanCloud\SaaSFramework\Services\ArtisanService\src
 */
class ArtisanService extends ArtisanCloudService
{

    public function __construct()
    {
        parent::__construct();
        $this->m_model = new Artisan();
    }

    public function getByMobile($mobile): ?Artisan
    {
        $artisan = $this->m_model->whereMobile($mobile)->first();
        return $artisan;
    }


    public function registerBy(array $arrayDate)
    {
        $mobile = $arrayDate['mobile'];
        $artisan = $this->getByMobile($mobile);
        if (!$artisan) {
            $artisan = $this->createBy($arrayDate);
        }
        return $artisan;
    }

    public function makeBy($arrayData)
    {
        $this->m_model->mobile = $arrayDate['mobile'];
        $this->m_model->email = $arrayDate['email'];
        $this->m_model->nickname = $arrayDate['name'];

        return $this->m_model;
    }


    public function isRegisteredByMobile($mobile): bool
    {
        return is_null($this->getArtisanByMobile());
    }

    public function createUserBy($arrayDate): ?Artisan
    {
        $this->m_model->mobile = $arrayDate['mobile'];
        $this->m_model->email = $arrayDate['email'];
        $this->m_model->nickname = $arrayDate['name'];

        $bResult = $this->m_model->save();

        return $bResult ? $this->m_model : null;
    }

}
