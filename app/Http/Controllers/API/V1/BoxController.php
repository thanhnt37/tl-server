<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\V1\BoxRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\BoxRepositoryInterface;
use App\Services\BoxServiceInterface;
use App\Services\UserServiceInterface;

class BoxController extends Controller
{
    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    /** @var \App\Services\BoxServiceInterface */
    protected $boxService;

    /** @var \App\Services\UserServiceInterface */
    protected $userService;

    public function __construct(
        BoxServiceInterface         $boxService,
        BoxRepositoryInterface      $boxRepository,
        UserServiceInterface        $userService
    ) {
        $this->boxService           = $boxService;
        $this->boxRepository        = $boxRepository;
        $this->userService          = $userService;
    }

    public function activateDevice(BoxRequest $request)
    {
        $data = $request->only(
            [
                'imei',
                'grant_type',
                'client_id',
                'client_secret'
            ]
        );

        $check = $this->userService->checkClient($request);
        if( !$check ) {
            return Response::response(40101);
        }

        $box = $this->boxRepository->findByImei($data['imei']);
        if( empty($box) ) {
            return Response::response(20004);
        }

        if( $box->is_blocked ) {
            return Response::response(40302);
        }

        if( !$box->is_activated ) {
            $box->is_activated = true;
            $box->activation_date = date('Y-m-d H:i:s');
            $this->boxRepository->save($box);
        }

        return Response::response(200, $box->toAPIArray());
    }
}
