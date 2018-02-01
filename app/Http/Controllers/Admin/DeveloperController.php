<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\DeveloperRepositoryInterface;
use App\Http\Requests\Admin\DeveloperRequest;
use App\Http\Requests\PaginationRequest;

class DeveloperController extends Controller
{
    /** @var \App\Repositories\DeveloperRepositoryInterface */
    protected $developerRepository;


    public function __construct(
        DeveloperRepositoryInterface $developerRepository
    ) {
        $this->developerRepository = $developerRepository;
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
        $paginate['baseUrl']    = action( 'Admin\DeveloperController@index' );

        $count = $this->developerRepository->count();
        $developers = $this->developerRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.developers.index',
            [
                'developers' => $developers,
                'count'      => $count,
                'paginate'   => $paginate,
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
            'pages.admin.' . config('view.admin') . '.developers.edit',
            [
                'isNew'     => true,
                'developer' => $this->developerRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(DeveloperRequest $request)
    {
        $input = $request->only(['name']);

        $developer = $this->developerRepository->create($input);

        if (empty( $developer )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\DeveloperController@index')
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
        $developer = $this->developerRepository->find($id);
        if (empty( $developer )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.developers.edit',
            [
                'isNew'     => false,
                'developer' => $developer,
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
    public function update($id, DeveloperRequest $request)
    {
        /** @var \App\Models\Developer $developer */
        $developer = $this->developerRepository->find($id);
        if (empty( $developer )) {
            abort(404);
        }
        $input = $request->only(['name']);
        
        $this->developerRepository->update($developer, $input);

        return redirect()->action('Admin\DeveloperController@show', [$id])
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
        /** @var \App\Models\Developer $developer */
        $developer = $this->developerRepository->find($id);
        if (empty( $developer )) {
            abort(404);
        }
        $this->developerRepository->delete($developer);

        return redirect()->action('Admin\DeveloperController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
