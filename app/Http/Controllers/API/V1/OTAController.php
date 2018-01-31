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
use App\Repositories\ApplicationRepositoryInterface;

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

    /** @var \App\Repositories\ApplicationRepositoryInterface */
    protected $applicationRepository;

    public function __construct(
        KaraOtaRepositoryInterface      $karaOtaRepository,
        SdkVersionRepositoryInterface   $sdkVersionRepository,
        KaraVersionRepositoryInterface  $karaVersionRepository,
        BoxRepositoryInterface          $boxRepository,
        ApplicationRepositoryInterface  $applicationRepository
    ) {
        $this->karaOtaRepository        = $karaOtaRepository;
        $this->sdkVersionRepository     = $sdkVersionRepository;
        $this->karaVersionRepository    = $karaVersionRepository;
        $this->boxRepository            = $boxRepository;
        $this->applicationRepository    = $applicationRepository;
    }

    public function updateOTA(OTARequest $request)
    {
        // apk_version_id = version code, sdk_version_id = sdk name
        // lấy các thông số box, application, sdk,
        // từ app_key -> application_id, cộng với apk_version_id -> app_version_id hiện tại của client
        // từ imei -> box_id, cộng với sdk_id từ sdk_version_id (value) để tìm đc các app_version_id setup trên sv, tìm đến app tương ứng rồi so sánh
        // nếu apk_version_id của client thấp hơn sv thì trả về apk_version_id theo sv

        $data = $request->only(
            ['imei', 'sdk_version_id', 'apk_version_id', 'app_key']
        );

        // check box is activated and not blocked
        $clientBox = $this->boxRepository->findByImei($data['imei']);
        if( empty($clientBox) ) {
            return Response::response(20004);
        }
        $clientSdk = $this->sdkVersionRepository->findByName($data['sdk_version_id']);
        if( empty($clientSdk) ) {
            return Response::response(20004);
        }
        $clientApp = $this->applicationRepository->findByAppKey($data['app_key']);
        if( empty($clientApp) ) {
            return Response::response(40003);
        }

        // get current app version
        $clientAppVersion = $this->karaVersionRepository->findByVersionAndApplicationId($data['apk_version_id'], $clientApp->id);
        if( empty($clientAppVersion) ) {
            return Response::response(20004);
        }

        // get OTA info by box_version_id and sdk_version_id
        $serverOTAs = $this->karaOtaRepository->getByBoxVersionIdAndSdkVersionId($clientBox->box_version_id, $clientSdk->id);
        if( empty($serverOTAs) ) {
            return Response::response(20004);
        }
        foreach ( $serverOTAs as $ota ) {
            if( isset($ota->karaVersion->application_id) && ($ota->karaVersion->application_id == $clientApp->id) ) {
                $serverOTA = $ota;

                break;
            }
        }
        if( !isset($serverOTA) || empty($serverOTA) ) {
            return Response::response(20004);
        }
        
        // if current app version is up to date -> response
        if( $clientAppVersion->id >= $serverOTA->app_version_id ) {
            return Response::response(20001);
        }

        // return new app version if current app version is out date
        $version  = $serverOTA->karaVersion;
        $response = $serverOTA->karaVersion->toAPIArray();
        if( empty($version->apkPackage) ) {
            return Response::response(20005);
        }

        $response['apk_url'] = \URLHelper::asset(config('file.categories.kara_apk.local_path') . $version->apkPackage->url, config('file.categories.kara_apk.local_type'));

        return Response::response(200, $response);
    }
}