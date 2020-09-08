<?php
declare(strict_types=1);

namespace ArtisanCloud\SaaSPolymer\Http\Controllers\API;


use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIController;
use ArtisanCloud\SaaSFramework\Http\Resources\LandlordResource;
use ArtisanCloud\SaaSFramework\Services\LandlordService\src\LandlordService;
use Illuminate\Http\Request;


class LandlordAPIController extends APIController
{

    protected $m_landlordService = null;

    function __construct(Request $request, LandlordService $service)
    {
        // init the default value
        // parent will construction automatically
        parent::__construct($request);

        $this->m_landlordService = $service;
    }


    public function apiGetList(Request $request)
    {
//        dd($request->all());

        $landlordList = $this->m_landlordService->getListForClient()->get();
//        $landlordList = $this->m_landlord->getCachedListForClient($para);
//        dd($landlordList);

        $apiResource = LandlordResource::collection($landlordList);
//        dd($apiResource);
        $this->m_apiResponse->setData($apiResource);

        return $this->m_apiResponse->toResponse();

    }


    public function apiGetDetail(Request $request)
    {
//        dd($request->all());
        $uuid = $this->m_requestData['uuid'];
//        dd($id);

        $landlord = $this->m_landlord->getDetailForClientByUUID($uuid);
//        $landlord = $this->m_landlord->getCachedDetailForClientByUUID($uuid);
//        dd($landlord);

        $apiResource = new LandlordResource($landlord);
        $this->setData($apiResource);

        return $this->getJSONResponse();

    }




}
