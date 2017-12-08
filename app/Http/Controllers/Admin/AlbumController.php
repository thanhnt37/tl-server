<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\AlbumRepositoryInterface;
use App\Http\Requests\Admin\AlbumRequest;
use App\Http\Requests\PaginationRequest;

class AlbumController extends Controller
{

    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $albumRepository;


    public function __construct(
        AlbumRepositoryInterface $albumRepository
    )
    {
        $this->albumRepository = $albumRepository;
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
        $paginate['baseUrl']    = action( 'Admin\AlbumController@index' );

        $count = $this->albumRepository->count();
        $albums = $this->albumRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.albums.index',
            [
                'albums'   => $albums,
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
            'pages.admin.' . config('view.admin') . '.albums.edit',
            [
                'isNew' => true,
                'album' => $this->albumRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(AlbumRequest $request)
    {
        $input = $request->only(['name','description','image','vote','publish_at']);

        $album = $this->albumRepository->create($input);

        if (empty( $album )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\AlbumController@index')
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
        $album = $this->albumRepository->find($id);
        if (empty( $album )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.albums.edit',
            [
                'isNew' => false,
                'album' => $album,
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
    public function update($id, AlbumRequest $request)
    {
        /** @var \App\Models\Album $album */
        $album = $this->albumRepository->find($id);
        if (empty( $album )) {
            abort(404);
        }
        $input = $request->only(['name','description','image','vote','publish_at']);
        
        $this->albumRepository->update($album, $input);

        return redirect()->action('Admin\AlbumController@show', [$id])
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
        /** @var \App\Models\Album $album */
        $album = $this->albumRepository->find($id);
        if (empty( $album )) {
            abort(404);
        }
        $this->albumRepository->delete($album);

        return redirect()->action('Admin\AlbumController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
