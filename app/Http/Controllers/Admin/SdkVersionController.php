<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SdkVersionRepositoryInterface;
use App\Http\Requests\Admin\SdkVersionRequest;
use App\Http\Requests\PaginationRequest;

class SdkVersionController extends Controller
{

    /** @var \App\Repositories\SdkVersionRepositoryInterface */
    protected $sdkVersionRepository;


    public function __construct(
        SdkVersionRepositoryInterface $sdkVersionRepository
    )
    {
        $this->sdkVersionRepository = $sdkVersionRepository;
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
        $paginate['baseUrl']    = action( 'Admin\SdkVersionController@index' );

        $count = $this->sdkVersionRepository->count();
        $sdkVersions = $this->sdkVersionRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.sdk-versions.index',
            [
                'sdkVersions' => $sdkVersions,
                'count'       => $count,
                'paginate'    => $paginate,
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
            'pages.admin.' . config('view.admin') . '.sdk-versions.edit',
            [
                'isNew'      => true,
                'sdkVersion' => $this->sdkVersionRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(SdkVersionRequest $request)
    {
        $input = $request->only(['name']);
        
        $sdkVersion = $this->sdkVersionRepository->create($input);

        if (empty( $sdkVersion )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\SdkVersionController@index')
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
        $sdkVersion = $this->sdkVersionRepository->find($id);
        if (empty( $sdkVersion )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.sdk-versions.edit',
            [
                'isNew'      => false,
                'sdkVersion' => $sdkVersion,
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
    public function update($id, SdkVersionRequest $request)
    {
        /** @var \App\Models\SdkVersion $sdkVersion */
        $sdkVersion = $this->sdkVersionRepository->find($id);
        if (empty( $sdkVersion )) {
            abort(404);
        }
        $input = $request->only(['name']);
        
        $this->sdkVersionRepository->update($sdkVersion, $input);

        return redirect()->action('Admin\SdkVersionController@show', [$id])
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
        /** @var \App\Models\SdkVersion $sdkVersion */
        $sdkVersion = $this->sdkVersionRepository->find($id);
        if (empty( $sdkVersion )) {
            abort(404);
        }
        $this->sdkVersionRepository->delete($sdkVersion);

        return redirect()->action('Admin\SdkVersionController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
