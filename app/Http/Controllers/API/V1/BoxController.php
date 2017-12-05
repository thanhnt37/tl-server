<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\BoxRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\BoxRepositoryInterface;
use App\Services\BoxServiceInterface;

class BoxController extends Controller
{
    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    /** @var \App\Services\BoxServiceInterface */
    protected $boxService;

    public function __construct(
        BoxServiceInterface         $boxService,
        BoxRepositoryInterface      $boxRepository
    ) {
        $this->boxService           = $boxService;
        $this->boxRepository        = $boxRepository;
    }

    public function activateDevice(BoxRequest $request)
    {
        $data = $request->only(
            ['imei', 'serial']
        );

        $box = $this->boxRepository->findByImeiAndSerial($data['imei'], $data['serial']);
        if( empty($box) ) {
            return Response::response(20004);
        }

        if( !$box->is_activated ) {
            $box->is_activated = true;
            $box->activation_date = date('Y-m-d H:i:s');
            $this->boxRepository->save($box);
        }

        return Response::response(200, $box->toAPIArray());
    }
}
