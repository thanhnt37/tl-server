<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\KaraOtaRepositoryInterface;
use App\Http\Requests\Admin\KaraOtaRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\KaraVersionRepositoryInterface;
use App\Repositories\OsVersionRepositoryInterface;
use App\Repositories\SdkVersionRepositoryInterface;
use App\Repositories\BoxVersionRepositoryInterface;

class AppOtaController extends Controller
{

    /** @var \App\Repositories\KaraOtaRepositoryInterface */
    protected $karaOtaRepository;

    /** @var \App\Repositories\KaraVersionRepositoryInterface */
    protected $karaVersionRepository;

    /** @var \App\Repositories\OsVersionRepositoryInterface */
    protected $osVersionRepository;

    /** @var \App\Repositories\SdkVersionRepositoryInterface */
    protected $sdkVersionRepository;

    /** @var \App\Repositories\BoxVersionRepositoryInterface */
    protected $boxVersionRepository;

    public function __construct(
        KaraOtaRepositoryInterface      $karaOtaRepository,
        KaraVersionRepositoryInterface  $karaVersionRepository,
        OsVersionRepositoryInterface    $osVersionRepository,
        SdkVersionRepositoryInterface   $sdkVersionRepository,
        BoxVersionRepositoryInterface   $boxVersionRepository
    )
    {
        $this->karaOtaRepository        = $karaOtaRepository;
        $this->karaVersionRepository    = $karaVersionRepository;
        $this->osVersionRepository      = $osVersionRepository;
        $this->sdkVersionRepository     = $sdkVersionRepository;
        $this->boxVersionRepository     = $boxVersionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Http\Requests\PaginationRequest $request
     * @return \Response
     */
    public function index(PaginationRequest $request)
    {
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\AppOtaController@index' );

        $count = $this->karaOtaRepository->count();
        $karaOtas = $this->karaOtaRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.app-ota.index',
            [
                'karaOtas' => $karaOtas,
                'count'    => $count,
                'paginate' => $paginate,
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view(
            'pages.admin.' . config('view.admin') . '.app-ota.edit',
            [
                'isNew'        => true,
                'karaOta'      => $this->karaOtaRepository->getBlankModel(),
                'karaVersions' => $this->karaVersionRepository->all(),
                'osVersions'   => $this->osVersionRepository->all(),
                'sdkVersions'  => $this->sdkVersionRepository->all(),
                'boxVersions'  => $this->boxVersionRepository->all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(KaraOtaRequest $request)
    {
        $input = $request->only(['os_version_id','sdk_version_id', 'box_version_id', 'kara_version_id']);

        $karaOta = $this->karaOtaRepository->create($input);

        if (empty( $karaOta )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\AppOtaController@index')
            ->with('message-success', trans('admin.messages.general.create_success'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function show($id)
    {
        $karaOta = $this->karaOtaRepository->find($id);
        if (empty( $karaOta )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.app-ota.edit',
            [
                'isNew'        => false,
                'karaOta'      => $karaOta,
                'karaVersions' => $this->karaVersionRepository->all(),
                'osVersions'   => $this->osVersionRepository->all(),
                'sdkVersions'  => $this->sdkVersionRepository->all(),
                'boxVersions'  => $this->boxVersionRepository->all(),
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @param      $request
     * @return \Response
     */
    public function update($id, KaraOtaRequest $request)
    {
        /** @var \App\Models\KaraOta $karaOta */
        $karaOta = $this->karaOtaRepository->find($id);
        if (empty( $karaOta )) {
            abort(404);
        }
        $input = $request->only(['os_version_id','sdk_version_id', 'box_version_id', 'kara_version_id']);

        $this->karaOtaRepository->update($karaOta, $input);

        return redirect()->action('Admin\AppOtaController@show', [$id])
                    ->with('message-success', trans('admin.messages.general.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function destroy($id)
    {
        /** @var \App\Models\KaraOta $karaOta */
        $karaOta = $this->karaOtaRepository->find($id);
        if (empty( $karaOta )) {
            abort(404);
        }
        $this->karaOtaRepository->delete($karaOta);

        return redirect()->action('Admin\AppOtaController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
