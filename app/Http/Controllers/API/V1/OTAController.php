<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Production\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\OTARequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\KaraOtaRepositoryInterface;

class OTAController extends Controller
{
    /** @var \App\Repositories\KaraOtaRepositoryInterface */
    protected $karaOtaRepository;

    public function __construct(
        KaraOtaRepositoryInterface  $karaOtaRepository
    ) {
        $this->karaOtaRepository    = $karaOtaRepository;
    }

    public function updateOTA(OTARequest $request)
    {
        $data = $request->only(
            ['sdk_version_id', 'apk_version_id']
        );

        $ota = $this->karaOtaRepository->findBySdkVersionId($data['sdk_version_id']);
        if( empty($ota) || !isset($ota->karaVersion) || empty($ota->karaVersion) ) {
            return Response::response(20004);
        }

        if( $data['apk_version_id'] >= $ota->kara_version_id ) {
            return Response::response(20001);
        }

        $version  = $ota->karaVersion;
        $response = $ota->karaVersion->toAPIArray();
        if( empty($version->apkPackage) ) {
            return Response::response(20004);
        }
        
        $response = ['id' => $version->id] + $response;
        $response['apk_url'] = \URLHelper::asset(config('file.categories.kara_apk.local_path') . $version->apkPackage->url, config('file.categories.kara_apk.local_type'));

        return Response::response(200, $response);
    }
}