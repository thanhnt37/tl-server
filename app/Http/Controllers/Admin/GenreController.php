<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\GenreRepositoryInterface;
use App\Http\Requests\Admin\GenreRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\GenreSongRepositoryInterface;
use App\Repositories\SongRepositoryInterface;

class GenreController extends Controller
{

    /** @var \App\Repositories\GenreRepositoryInterface */
    protected $genreRepository;

    /** @var \App\Repositories\GenreSongRepositoryInterface */
    protected $genreSongRepository;

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    public function __construct(
        GenreRepositoryInterface        $genreRepository,
        GenreSongRepositoryInterface    $genreSongRepository,
        SongRepositoryInterface         $songRepository
    )
    {
        $this->genreRepository          = $genreRepository;
        $this->genreSongRepository      = $genreSongRepository;
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
        $paginate['baseUrl']    = action( 'Admin\GenreController@index' );

        $count = $this->genreRepository->count();
        $genres = $this->genreRepository->get( $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit'] );

        return view(
            'pages.admin.' . config('view.admin') . '.genres.index',
            [
                'genres'   => $genres,
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
            'pages.admin.' . config('view.admin') . '.genres.edit',
            [
                'isNew' => true,
                'genre' => $this->genreRepository->getBlankModel(),
            ]
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  $request
     * @return \Response
     */
    public function store(GenreRequest $request)
    {
        $input = $request->only(['name','description','image']);

        $genre = $this->genreRepository->create($input);

        if (empty( $genre )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        return redirect()->action('Admin\GenreController@index')
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
        $genre = $this->genreRepository->find($id);
        if (empty( $genre )) {
            abort(404);
        }

//        $exceptSongs = $this->genreSongRepository->getByGenreId($id)->pluck('song_id');
//        $songs = $this->songRepository->getBlankModel()->whereNotIn('id', $exceptSongs)->get();

        return view(
            'pages.admin.' . config('view.admin') . '.genres.edit',
            [
                'isNew' => false,
                'genre' => $genre,
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
    public function update($id, GenreRequest $request)
    {
        /** @var \App\Models\Genre $genre */
        $genre = $this->genreRepository->find($id);
        if (empty( $genre )) {
            abort(404);
        }
        $input = $request->only(['name','description','image']);

        $this->genreRepository->update($genre, $input);

        return redirect()->action('Admin\GenreController@show', [$id])
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
        /** @var \App\Models\Genre $genre */
        $genre = $this->genreRepository->find($id);
        if (empty( $genre )) {
            abort(404);
        }
        $this->genreRepository->delete($genre);

        return redirect()->action('Admin\GenreController@index')
                    ->with('message-success', trans('admin.messages.general.delete_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function deleteSong($genreId, $songId)
    {
        /** @var \App\Models\AlbumSong $albumSong */
        $genreSong = $this->genreSongRepository->findByGenreIdAndSongId($genreId, $songId);
        if (empty( $genreSong )) {
            abort(404);
        }
        $this->genreSongRepository->delete($genreSong);

        return redirect()->back()->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function addNewSong($id, GenreRequest $request)
    {
        $genre = $this->genreRepository->find($id);
        if (empty( $genre )) {
            dd($genre);
            abort(404);
        }

        $songs = $request->get('new-songs', []);
        foreach( $songs as $songId ) {
            $check = $this->genreSongRepository->findByGenreIdAndSongId($genre->id, $songId);
            if( empty($check) ) {
                $this->genreSongRepository->create(
                    [
                        'genre_id' => $genre->id,
                        'song_id'  => $songId
                    ]
                );
            }
        }

        return redirect()->action('Admin\GenreController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }
}
