<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Services\ArtisanService\src;

use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models\Artisan;

use App\Models\User;

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


    /**
     * Register a artisan
     *
     * @param array $arrayData
     *
     * @return Artisan|null
     */
    public function registerBy(array $arrayData)
    {
        $mobile = $arrayData['mobile'];
        $artisan = $this->getByMobile($mobile);
        if (!$artisan) {
            $artisan = $this->createBy($arrayData);
        }
        return $artisan;
    }

    /**
     * make a artisan model
     *
     * @param array $arrayData
     *
     * @return mixed
     */
    public function makeBy($arrayData)
    {
        $this->m_model = $this->m_model->firstOrNew(
            ['mobile' => $arrayData['mobile']],
            $arrayData
        );
        $this->m_model->password = encodePlainPassword($arrayData['password']);
//        dd($this->m_model);
        return $this->m_model;
    }

    /**
     * create a artisan model
     *
     * @param array $arrayData
     *
     * @return mixed
     */
    public function createBy($arrayData)
    {
        $this->m_model = $this->m_model->makeBy($arrayData);
//        dd($this->m_model);

        $bResult = $this->m_model->save();

        return $bResult ? $this->m_model : null;
    }


    public function isRegisteredByMobile($mobile): bool
    {
        return is_null($this->getArtisanByMobile());
    }

    /**
     * make a user model and persist it
     *
     * @param array $arrayData
     *
     * @return User|null
     */
    public function createUserBy(array $arrayData): ?User
    {
//        dd($arrayData);
        $user = $this->makeUserBy($arrayData);
//        dd($user);
        $bResult = $user->save();

        return $bResult ? $user : null;

        return $user;
    }

    /**
     * make a user model
     *
     * @param array $arrayData
     *
     * @return User|null
     */
    public function makeUserBy($arrayData): ?User
    {
        $user = User::create($arrayData);

        return $user;
    }


    /**
     * set current session auth artisan
     *
     * @param Artisan $artisan
     *
     */

    public static function setAuthArtisan($artisan)
    {
        session(['authArtisan' => $artisan]);
    }

    /**
     * return current session auth artisan
     *
     * @return Artisan $artisan
     */
    public static function getAuthArtisan(): ?Artisan
    {
        return session('authArtisan');
    }

}
