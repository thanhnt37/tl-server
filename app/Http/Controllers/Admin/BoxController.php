<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\BoxRepositoryInterface;
use App\Http\Requests\Admin\BoxRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\OsVersionRepositoryInterface;
use App\Repositories\SdkVersionRepositoryInterface;
use App\Repositories\BoxVersionRepositoryInterface;

class BoxController extends Controller
{
    /** @var \App\Repositories\BoxRepositoryInterface */
    protected $boxRepository;

    /** @var \App\Repositories\OsVersionRepositoryInterface */
    protected $osVersionRepository;

    /** @var \App\Repositories\SdkVersionRepositoryInterface */
    protected $sdkVersionRepository;

    /** @var \App\Repositories\BoxVersionRepositoryInterface */
    protected $boxVersionRepository;

    public function __construct(
        BoxRepositoryInterface          $boxRepository,
        OsVersionRepositoryInterface    $osVersionRepository,
        SdkVersionRepositoryInterface   $sdkVersionRepository,
        BoxVersionRepositoryInterface   $boxVersionRepository
    )
    {
        $this->boxRepository            = $boxRepository;
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
        $paginate['baseUrl']    = action( 'Admin\BoxController@index' );

        $count = $this->boxRepository->count();
        $boxs = $this->boxRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.boxes.index',
            [
                'boxs'     => $boxs,
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
            'pages.admin.' . config('view.admin') . '.boxes.edit',
            [
                'isNew'       => true,
                'box'         => $this->boxRepository->getBlankModel(),
                'osVersions'  => $this->osVersionRepository->all(),
                'sdkVersions' => $this->sdkVersionRepository->all(),
                'boxVersions' => $this->boxVersionRepository->all(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(BoxRequest $request)
    {
        $input = $request->only(['imei','serial','model','os_version_id','sdk_version_id','box_version_id','activation_date']);
        $input['is_activated'] = $request->get('is_activated', 0);

        $box = $this->boxRepository->create($input);

        if (empty( $box )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\BoxController@index')
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
        $box = $this->boxRepository->find($id);
        if (empty( $box )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.boxes.edit',
            [
                'isNew'       => false,
                'box'         => $box,
                'osVersions'  => $this->osVersionRepository->all(),
                'sdkVersions' => $this->sdkVersionRepository->all(),
                'boxVersions' => $this->boxVersionRepository->all(),
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
    public function update($id, BoxRequest $request)
    {
        /** @var \App\Models\Box $box */
        $box = $this->boxRepository->find($id);
        if (empty( $box )) {
            abort(404);
        }
        $input = $request->only(['imei','serial','model','os_version_id','sdk_version_id','box_version_id','activation_date']);
        $input['is_activated'] = $request->get('is_activated', 0);

        $this->boxRepository->update($box, $input);

        return redirect()->action('Admin\BoxController@show', [$id])
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
        /** @var \App\Models\Box $box */
        $box = $this->boxRepository->find($id);
        if (empty( $box )) {
            abort(404);
        }
        $this->boxRepository->delete($box);

        return redirect()->action('Admin\BoxController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
