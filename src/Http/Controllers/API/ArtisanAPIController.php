<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Http\Controllers\API;

use ArtisanCloud\SaaSMonomer\Services\TenantService\src\Models\Tenant;
use ArtisanCloud\SaaSMonomer\Services\TenantService\src\TenantService;
use ArtisanCloud\SaaSPolymer\Events\UserRegistered;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\Models\Artisan;
use ArtisanCloud\SaaSFramework\Http\Resources\ArtisanResource;

use App\Http\Resources\UserResource;
use App\Models\User;
use ArtisanCloud\SaaSMonomer\Services\LandlordService\src\LandlordService;
use ArtisanCloud\SaaSPolymer\Http\Requests\RequestArtisanRegisterInvitation;
use ArtisanCloud\SaaSPolymer\Services\ArtisanService\src\ArtisanService;

use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIController;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use mysql_xdevapi\Exception;


class ArtisanAPIController extends APIController
{
    protected ArtisanService $artisanService;

    function __construct(Request $request, ArtisanService $artisanService)
    {
        // init the default value
        // parent will construction automatically
        parent::__construct($request);

//        $this->m_artisan = $artisan;
        $this->artisanService = $artisanService;
    }


    /**
     * API Get Service
     * name: artisan.read.service
     * description: get service
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiGetService(Request $request): JsonResponse
    {

        $data = $request->all();

        $this->m_apiResponse->pushDataWithKeyValue("client says:", $data);
        $this->m_apiResponse->pushDataWithKeyValue("Service says", "I am Artisan Service");

        $this->m_apiResponse->setCode(API_ERR_CODE_REQUEST_PARAMETER, API_RETURN_CODE_WARNING);

        return $this->m_apiResponse->toResponse();

    }

    public function apiRegisterInvitation(
        RequestArtisanRegisterInvitation $request,
        ArtisanService $artisanService,
        LandlordService $landlordService,
        TenantService $tenantService
    )
    {
        $user = \DB::connection('pgsql')->transaction(function () use (
            $request,
            $artisanService,
            $landlordService,
            $tenantService
        ) {

            try {

                $arrayData = $request->all();
//                dd($arrayData);

                // check if artisan has registered artisan
                $artisan = $artisanService->registerBy($arrayData);
                if (is_null($artisan)) {
                    throw new \Exception('', API_ERR_CODE_FAIL_TO_CREATE_ARTISAN);
                }
//            dd($artisan);

                // get Landlord info
                $landlord = $landlordService->getModelForClientByUUID($request->input('landlord_uuid'));
                if (is_null($landlord)) {
                    throw new \Exception('', API_ERR_CODE_LANDLORD_NOT_EXIST);
                }
//                dd($landlord);


                // create user
                $user = $artisanService->makeUserBy($arrayData);
                $user->artisan()->associate($artisan);
                $user->landlord()->associate($landlord);
                $user->save();

                // create a tenant for user
                $arrayDBInfo = $tenantService->generateDatabaseAccessInfoBy(Tenant::TYPE_USER, $artisan->short_name, $user->uuid);
                $arrayDBInfo['type'] = Tenant::TYPE_USER;
                $arrayDBInfo['tenantable_uuid'] = $user->uuid;
                $tenant = $tenantService->createBy($arrayDBInfo);


            } catch (\Exception $e) {
//                dd($e);
                throw new BaseException(
                    intval($e->getCode()),
                    $e->getMessage()
                );
            }

            return $user;

        });

        // dispatch user registerd event
        if ($user) {
            $user->loadMissing('tenant');
//            dd($user);
            event(new UserRegistered($user));
        }


        $this->m_apiResponse->setData(new UserResource($user));

        return $this->m_apiResponse->toResponse();
    }


    /**
     * API Get Me.
     * Name: artisan.read.me
     * Description: my profile and ping server
     *
     * @param Request
     *
     * @return JsonResponse
     *
     */
    public function apiMe(Request $request): JsonResponse
    {

//        $artisan = ArtisanService::getAuthArtisan();
//        $meID = $artisan->uuid;
//
//        $cacheTag = class_basename('Artisan');
//        $cacheKey = "me.{$meID}";
//        //暫時不用緩存
////        $artisan = \Cache::tags($cacheTag)->remember($cacheKey, CacheAPIController::SYSTEM_CACHE_TIMEOUT, function () use ($artisan) {
////
////            $artisan->lead;
////            $artisan->lead->studio;
////            $artisan->account;
////            $artisan->account->studio;
////
////            return $artisan;
////        });
//
////        dump($artisan);

//        return SpaceAPIResponse::success(new ArtisanResource($artisan));

        return $this->m_apiResponse->toResponse();

    }


    /**
     * API Update Artisan locale
     * name: me.update.locale
     * description: update artisan locale
     *
     * @@param Request $request
     *
     * @return JsonResponse
     */
    public function apiUpdateArtisanLocale(Request $request): JsonResponse
    {
////        dd($this->m_requestData);
//        $me = ArtisanService::getAuthArtisan();
////        dd($me);
//        $me->locale = $this->m_requestData['locale'];
////        dd($me->locale);
//        $bResult = $me->save();
//        if ($me->save()) {
//
//            // reset client local
//            $client = (new ClientProfile())->getProfile();
//            $client->locale = $me->locale;
//            $client->save();
//
//
//            $meID = $me->id;
//
////            $cacheTag = Artisan::COMMON_NAME;
//            $cacheKey = "me.{$meID}.locale";
//            \Cache::forget($cacheKey);
//            $cacheTag = class_basename('ClientProfile');
//            $cacheKey = "client.{$client->platform}.{$client->channel}.{$client->uuid}.locale";
////            dd($cacheKey);
//            \Cache::tags($cacheTag)->forget($cacheKey);
//
//            $this->setData($bResult);
//        } else {
//            $this->setCode(API_ERR_CODE_FAIL_TO_UPDATE_LOCALE);
//        }
//
//        return $this->getJSONResponse();
        return $this->m_apiResponse->toResponse();

    }


    /**
     * API Reset password
     * name: artisan.update.password-reset
     * description: reset artisan password
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiResetPassword(Request $request)
    {
////        dd($request->get('mobile'));
//        $artisanname = $request->get('mobile');
//        $artisan = $this->m_artisan->getArtisanByArtisanName($artisanname);
////        dd($artisan);
//
//        $strEncodePassword = encodeHashedPassword($this->m_requestData['password']);
//        $artisan->password = $strEncodePassword;
//        $bResult = $artisan->save();
//        if ($artisan->save()) {
//
//            $this->setResultCode(API_RESULT_CODE_SUCCESS_RESET_PASSWORD);
//            $this->setData($bResult);
//        } else {
//            $this->setCode(API_ERR_CODE_FAIL_TO_UPDATE_LOCALE);
//        }
//
//        return $this->getJSONResponse();

        return $this->m_apiResponse->toResponse();
    }


    /**
     * API Update password
     * name: me.update.password-update
     * description: update artisan password
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function apiUpdatePassword(Request $request): JsonResponse
    {
//        dd($this->m_requestData);
//        $me = ArtisanService::getAuthArtisan();
//
//        $strEncodePassword = encodeHashedPassword($this->m_requestData['password']);
//        $me->password = $strEncodePassword;
//        $bResult = $me->save();
//        if ($me->save()) {
//
//            $this->setResultCode(API_RESULT_CODE_SUCCESS_RESET_PASSWORD);
//            $this->setData($bResult);
//        } else {
//            $this->setCode(API_ERR_CODE_FAIL_TO_UPDATE_LOCALE);
//        }
//
//        return $this->getJSONResponse();

        return $this->m_apiResponse->toResponse();
    }


}
