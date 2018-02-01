<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\StoreApplicationRepositoryInterface;
use App\Http\Requests\Admin\StoreApplicationRequest;
use App\Http\Requests\PaginationRequest;

class StoreApplicationController extends Controller
{
    /** @var \App\Repositories\StoreApplicationRepositoryInterface */
    protected $storeApplicationRepository;


    public function __construct(
        StoreApplicationRepositoryInterface $storeApplicationRepository
    ) {
        $this->storeApplicationRepository = $storeApplicationRepository;
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
        $paginate['direction']  = $request->direction('asc');
        $paginate['baseUrl']    = action( 'Admin\StoreApplicationController@index' );

        $count = $this->storeApplicationRepository->count();
        $storeApplications = $this->storeApplicationRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.store-applications.index',
            [
                'storeApplications' => $storeApplications,
                'count'             => $count,
                'paginate'          => $paginate,
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
            'pages.admin.' . config('view.admin') . '.store-applications.edit',
            [
                'isNew'            => true,
                'storeApplication' => $this->storeApplicationRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(StoreApplicationRequest $request)
    {
        $input = $request->only(['name', 'version_name', 'version_code', 'package_name', 'description', 'hit', 'publish_started_at']);

        $storeApplication = $this->storeApplicationRepository->create($input);

        if (empty( $storeApplication )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\StoreApplicationController@index')
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
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.store-applications.edit',
            [
                'isNew'            => false,
                'storeApplication' => $storeApplication,
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
    public function update($id, StoreApplicationRequest $request)
    {
        /** @var \App\Models\StoreApplication $storeApplication */
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }
        $input = $request->only(['name','version_name','version_code','package_name','description','hit','publish_started_at']);

        $this->storeApplicationRepository->update($storeApplication, $input);

        return redirect()->action('Admin\StoreApplicationController@show', [$id])
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
        /** @var \App\Models\StoreApplication $storeApplication */
        $storeApplication = $this->storeApplicationRepository->find($id);
        if (empty( $storeApplication )) {
            abort(404);
        }
        $this->storeApplicationRepository->delete($storeApplication);

        return redirect()->action('Admin\StoreApplicationController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
