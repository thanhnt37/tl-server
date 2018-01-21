<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\OsVersionRepositoryInterface;
use App\Http\Requests\Admin\OsVersionRequest;
use App\Http\Requests\PaginationRequest;

class OsVersionController extends Controller
{

    /** @var \App\Repositories\OsVersionRepositoryInterface */
    protected $osVersionRepository;


    public function __construct(
        OsVersionRepositoryInterface $osVersionRepository
    )
    {
        $this->osVersionRepository = $osVersionRepository;
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
        $paginate['order']      = $request->order('id');
        $paginate['direction']  = $request->direction('asc');
        $paginate['baseUrl']    = action( 'Admin\OsVersionController@index' );

        $count = $this->osVersionRepository->count();
        $osVersions = $this->osVersionRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view('pages.admin.' . config('view.admin') . '.os-versions.index', [
            'osVersions'    => $osVersions,
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
            'pages.admin.' . config('view.admin') . '.os-versions.edit',
            [
                'isNew'     => true,
                'osVersion' => $this->osVersionRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(OsVersionRequest $request)
    {
        $input = $request->only(['name']);

        $osVersion = $this->osVersionRepository->create($input);

        if (empty( $osVersion )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\OsVersionController@index')
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
        $osVersion = $this->osVersionRepository->find($id);
        if (empty( $osVersion )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.os-versions.edit',
            [
                'isNew'     => false,
                'osVersion' => $osVersion,
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
    public function update($id, OsVersionRequest $request)
    {
        /** @var \App\Models\OsVersion $osVersion */
        $osVersion = $this->osVersionRepository->find($id);
        if (empty( $osVersion )) {
            abort(404);
        }
        $input = $request->only(['name']);
        
        $this->osVersionRepository->update($osVersion, $input);

        return redirect()->action('Admin\OsVersionController@show', [$id])
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
        /** @var \App\Models\OsVersion $osVersion */
        $osVersion = $this->osVersionRepository->find($id);
        if (empty( $osVersion )) {
            abort(404);
        }
        $this->osVersionRepository->delete($osVersion);

        return redirect()->action('Admin\OsVersionController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
