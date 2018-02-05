<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\StoreApplicationRepositoryInterface;

class StoreApplicationController extends Controller
{
    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $storeApplicationRepository;

    public function __construct(
        StoreApplicationRepositoryInterface    $storeApplicationRepository
    ) {
        $this->storeApplicationRepository = $storeApplicationRepository;
    }

    public function getAppInfo($id)
    {
        $storeApp = $this->storeApplicationRepository->find($id);
        if (empty($storeApp)) {
            return Response::response(20004);
        }

        $hit = $storeApp->hit;
        $hit = is_numeric($hit) ? $hit : 0;
        $storeApp->hit = $hit + 1;
        $this->storeApplicationRepository->save($storeApp);

        return Response::response(200, $storeApp->toAPIArray());
    }
}
