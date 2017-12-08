<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SingerRepositoryInterface;
use App\Http\Requests\Admin\SingerRequest;
use App\Http\Requests\PaginationRequest;

class SingerController extends Controller
{

    /** @var \App\Repositories\SingerRepositoryInterface */
    protected $singerRepository;


    public function __construct(
        SingerRepositoryInterface $singerRepository
    )
    {
        $this->singerRepository = $singerRepository;
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
        $paginate['baseUrl']    = action( 'Admin\SingerController@index' );

        $count = $this->singerRepository->count();
        $singers = $this->singerRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.singers.index',
            [
                'singers'  => $singers,
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
            'pages.admin.' . config('view.admin') . '.singers.edit',
            [
                'isNew'  => true,
                'singer' => $this->singerRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(SingerRequest $request)
    {
        $input = $request->only(['name','description','image']);

        $singer = $this->singerRepository->create($input);

        if (empty( $singer )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\SingerController@index')
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
        $singer = $this->singerRepository->find($id);
        if (empty( $singer )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.singers.edit',
            [
                'isNew'  => false,
                'singer' => $singer,
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
    public function update($id, SingerRequest $request)
    {
        /** @var \App\Models\Singer $singer */
        $singer = $this->singerRepository->find($id);
        if (empty( $singer )) {
            abort(404);
        }
        $input = $request->only(['name','description','image']);
        
        $this->singerRepository->update($singer, $input);

        return redirect()->action('Admin\SingerController@show', [$id])
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
        /** @var \App\Models\Singer $singer */
        $singer = $this->singerRepository->find($id);
        if (empty( $singer )) {
            abort(404);
        }
        $this->singerRepository->delete($singer);

        return redirect()->action('Admin\SingerController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
