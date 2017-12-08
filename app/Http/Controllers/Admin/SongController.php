<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SongRepositoryInterface;
use App\Http\Requests\Admin\SongRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\AuthorRepositoryInterface;

class SongController extends Controller
{

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    /** @var \App\Repositories\AuthorRepositoryInterface */
    protected $authorRepository;

    public function __construct(
        SongRepositoryInterface     $songRepository,
        AuthorRepositoryInterface   $authorRepository
    )
    {
        $this->songRepository       = $songRepository;
        $this->authorRepository     = $authorRepository;
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
        $paginate['baseUrl']    = action( 'Admin\SongController@index' );

        $count = $this->songRepository->count();
        $songs = $this->songRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.songs.index',
            [
                'songs'    => $songs,
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
            'pages.admin.' . config('view.admin') . '.songs.edit',
            [
                'isNew'   => true,
                'song'    => $this->songRepository->getBlankModel(),
                'authors' => $this->authorRepository->all()
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(SongRequest $request)
    {
        $input = $request->only(['code','wildcard','name','description','author_id','link','type','sub_link','image','view','play','vote','publish_at']);

        $song = $this->songRepository->create($input);

        if (empty( $song )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\SongController@index')
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
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }

        return view(
            'pages.admin.' . config('view.admin') . '.songs.edit',
            [
                'isNew'   => false,
                'song'    => $song,
                'authors' => $this->authorRepository->all()
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
    public function update($id, SongRequest $request)
    {
        /** @var \App\Models\Song $song */
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }
        $input = $request->only(['code','wildcard','name','description','author_id','link','type','sub_link','image','view','play','vote','publish_at']);

        $this->songRepository->update($song, $input);

        return redirect()->action('Admin\SongController@show', [$id])
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
        /** @var \App\Models\Song $song */
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }
        $this->songRepository->delete($song);

        return redirect()->action('Admin\SongController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

}
