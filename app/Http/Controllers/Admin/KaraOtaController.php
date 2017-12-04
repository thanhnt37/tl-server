<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\KaraOtaRepositoryInterface;
use App\Http\Requests\Admin\KaraOtaRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\KaraVersionRepositoryInterface;

class KaraOtaController extends Controller
{

    /** @var \App\Repositories\KaraOtaRepositoryInterface */
    protected $karaOtaRepository;

    /** @var \App\Repositories\KaraVersionRepositoryInterface */
    protected $karaVersionRepository;

    public function __construct(
        KaraOtaRepositoryInterface      $karaOtaRepository,
        KaraVersionRepositoryInterface  $karaVersionRepository
    )
    {
        $this->karaOtaRepository        = $karaOtaRepository;
        $this->karaVersionRepository    = $karaVersionRepository;
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
        $paginate['baseUrl']    = action( 'Admin\KaraOtaController@index' );

        $count = $this->karaOtaRepository->count();
        $karaOtas = $this->karaOtaRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view('pages.admin.' . config('view.admin') . '.kara-ota.index', [
            'karaOtas'    => $karaOtas,
            'count'         => $count,
            'paginate'      => $paginate,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Response
     */
    public function create()
    {
        return view(
            'pages.admin.' . config('view.admin') . '.kara-ota.edit',
            [
                'isNew'        => true,
                'karaOta'      => $this->karaOtaRepository->getBlankModel(),
                'karaVersions' => $this->karaVersionRepository->all()
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
        $input = $request->only(['os_version','box_version', 'kara_version_id']);

        $karaOta = $this->karaOtaRepository->create($input);

        if (empty( $karaOta )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\KaraOtaController@index')
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
            'pages.admin.' . config('view.admin') . '.kara-ota.edit',
            [
                'isNew'        => false,
                'karaOta'      => $karaOta,
                'karaVersions' => $this->karaVersionRepository->all()
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
        $input = $request->only(['os_version','box_version', 'kara_version_id']);

        $this->karaOtaRepository->update($karaOta, $input);

        return redirect()->action('Admin\KaraOtaController@show', [$id])
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

        return redirect()->action('Admin\KaraOtaController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
