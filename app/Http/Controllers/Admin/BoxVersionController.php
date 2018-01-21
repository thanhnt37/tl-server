<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\BoxVersionRepositoryInterface;
use App\Http\Requests\Admin\BoxVersionRequest;
use App\Http\Requests\PaginationRequest;

class BoxVersionController extends Controller
{

    /** @var \App\Repositories\BoxVersionRepositoryInterface */
    protected $boxVersionRepository;


    public function __construct(
        BoxVersionRepositoryInterface $boxVersionRepository
    )
    {
        $this->boxVersionRepository = $boxVersionRepository;
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
        $paginate['baseUrl']    = action( 'Admin\BoxVersionController@index' );

        $count = $this->boxVersionRepository->count();
        $boxVersions = $this->boxVersionRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.box-versions.index',
            [
                'boxVersions' => $boxVersions,
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
            'pages.admin.' . config('view.admin') . '.box-versions.edit',
            [
                'isNew'      => true,
                'boxVersion' => $this->boxVersionRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(BoxVersionRequest $request)
    {
        $input = $request->only(['name']);

        $boxVersion = $this->boxVersionRepository->create($input);

        if (empty( $boxVersion )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\BoxVersionController@index')
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
        $boxVersion = $this->boxVersionRepository->find($id);
        if (empty( $boxVersion )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.box-versions.edit',
            [
                'isNew'      => false,
                'boxVersion' => $boxVersion,
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
    public function update($id, BoxVersionRequest $request)
    {
        /** @var \App\Models\BoxVersion $boxVersion */
        $boxVersion = $this->boxVersionRepository->find($id);
        if (empty( $boxVersion )) {
            abort(404);
        }
        $input = $request->only(['name']);
        
        $this->boxVersionRepository->update($boxVersion, $input);

        return redirect()->action('Admin\BoxVersionController@show', [$id])
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
        /** @var \App\Models\BoxVersion $boxVersion */
        $boxVersion = $this->boxVersionRepository->find($id);
        if (empty( $boxVersion )) {
            abort(404);
        }
        $this->boxVersionRepository->delete($boxVersion);

        return redirect()->action('Admin\BoxVersionController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
