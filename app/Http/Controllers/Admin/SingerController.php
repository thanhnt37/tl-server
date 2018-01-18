<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\SingerRepositoryInterface;
use App\Http\Requests\Admin\SingerRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\SingerSongRepositoryInterface;
use App\Repositories\SongRepositoryInterface;

class SingerController extends Controller
{
    /** @var \App\Repositories\SingerRepositoryInterface */
    protected $singerRepository;

    /** @var \App\Repositories\SingerSongRepositoryInterface */
    protected $singerSongRepository;

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    public function __construct(
        SingerRepositoryInterface       $singerRepository,
        SingerSongRepositoryInterface   $singerSongRepository,
        SongRepositoryInterface         $songRepository
    )
    {
        $this->singerRepository         = $singerRepository;
        $this->singerSongRepository     = $singerSongRepository;
        $this->songRepository           = $songRepository;
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

//        $exceptSongs = $this->singerSongRepository->getBySingerId($id)->pluck('singer_id');
//        $songs = $this->songRepository->getBlankModel()->whereNotIn('id', $exceptSongs)->get();

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function deleteSong($singerId, $songId)
    {
        /** @var \App\Models\AlbumSong $albumSong */
        $singerSong = $this->singerSongRepository->findBySingerIdAndSongId($singerId, $songId);
        if (empty( $singerSong )) {
            abort(404);
        }
        $this->singerSongRepository->delete($singerSong);

        return redirect()->back()->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function addNewSong($id, SingerRequest $request)
    {
        $singer = $this->singerRepository->find($id);
        if (empty( $singer )) {
            abort(404);
        }

        $songs = $request->get('new-songs', []);
        foreach( $songs as $songId ) {
            $check = $this->singerSongRepository->findBySingerIdAndSongId($singer->id, $songId);
            if( empty($check) ) {
                $this->singerSongRepository->create(
                    [
                        'singer_id' => $singer->id,
                        'song_id'   => $songId
                    ]
                );
            }
        }

        return redirect()->action('Admin\SingerController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }
}
