<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\Production\URLHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\OTARequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\KaraOtaRepositoryInterface;
use App\Repositories\SdkVersionRepositoryInterface;
use App\Repositories\KaraVersionRepositoryInterface;
use App\Repositories\BoxRepositoryInterface;

class OTAController extends Controller
{
    /** @var \App\Repositories\KaraOtaRepositoryInterface */
    protected $karaOtaRepository;

    /** @var \App\Repositories\SdkVersionRepositoryInterface */
    protected $sdkVersionRepository;

    /** @var \App\Repositories\KaraVersionRepositoryInterface */
    protected $karaVersionRepository;

    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    public function __construct(
        KaraOtaRepositoryInterface      $karaOtaRepository,
        SdkVersionRepositoryInterface   $sdkVersionRepository,
        KaraVersionRepositoryInterface  $karaVersionRepository,
        BoxRepositoryInterface          $boxRepository
    ) {
        $this->karaOtaRepository        = $karaOtaRepository;
        $this->sdkVersionRepository     = $sdkVersionRepository;
        $this->karaVersionRepository    = $karaVersionRepository;
        $this->boxRepository            = $boxRepository;
    }

    public function updateOTA(OTARequest $request)
    {
        $data = $request->only(
            ['imei', 'sdk_version_id', 'apk_version_id']
        );

        $box = $this->boxRepository->findByImei($data['imei']);
        if( empty($box) ) {
            return Response::response(20004);
        }

        $sdkVersion = $this->sdkVersionRepository->findByName($data['sdk_version_id']);
        if( empty($sdkVersion) ) {
            return Response::response(20004);
        }

        $ota = $this->karaOtaRepository->findByBoxVersionIdAndSdkVersionId($box->box_version_id, $sdkVersion->id);
        if( empty($ota) || !isset($ota->karaVersion) || empty($ota->karaVersion) ) {
            return Response::response(20004);
        }

        $karaVersion = $this->karaVersionRepository->findByVersion($data['apk_version_id']);
        if( empty($karaVersion) ) {
            return Response::response(20004);
        }

        if( $karaVersion->id >= $ota->kara_version_id ) {
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