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
            ['os_version', 'sdk_version']
        );

        $ota = $this->karaOtaRepository->findByOsVersionIdAndSdkVersionId($data['os_version'], $data['sdk_version']);
        if( empty($ota) || !isset($ota->karaVersion) || empty($ota->karaVersion) ) {
            return Response::response(20004);
        }

        $version  = $ota->karaVersion;
        $response = $ota->karaVersion->toAPIArray();
        if( empty($version->apkPackage) ) {
            return Response::response(20004);
        }
        $response['apk_url'] = \URLHelper::asset(config('file.categories.kara_apk.local_path') . '/' . $version->apkPackage->url, config('file.categories.kara_apk.local_type'));

        return Response::response(200, $response);
    }
}