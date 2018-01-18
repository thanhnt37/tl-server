<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Responses\API\V1\Response;
use App\Repositories\SongRepositoryInterface;
use App\Http\Requests\Admin\SongRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\AuthorRepositoryInterface;
use App\Repositories\AlbumSongRepositoryInterface;
use App\Repositories\GenreSongRepositoryInterface;
use App\Repositories\SingerSongRepositoryInterface;
use App\Repositories\AlbumRepositoryInterface;
use App\Repositories\GenreRepositoryInterface;
use App\Repositories\SingerRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Repositories\ImageRepositoryInterface;

class SongController extends Controller
{

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    /** @var \App\Repositories\AuthorRepositoryInterface */
    protected $authorRepository;

    /** @var \App\Repositories\AlbumSongRepositoryInterface */
    protected $albumSongRepository;

    /** @var \App\Repositories\GenreSongRepositoryInterface */
    protected $genreSongRepository;

    /** @var \App\Repositories\SingerSongRepositoryInterface */
    protected $singerSongRepository;

    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $albumRepository;

    /** @var \App\Repositories\GenreRepositoryInterface */
    protected $genreRepository;

    /** @var \App\Repositories\SingerRepositoryInterface */
    protected $singerRepository;

    /** @var \App\Services\FileUploadServiceInterface */
    protected $fileUploadService;

    /** @var  \App\Services\ImageServiceInterface */
    protected $imageService;

    /** @var  \App\Repositories\ImageRepositoryInterface */
    protected $imageRepository;

    public function __construct(
        SongRepositoryInterface         $songRepository,
        AuthorRepositoryInterface       $authorRepository,
        AlbumSongRepositoryInterface    $albumSongRepository,
        GenreSongRepositoryInterface    $genreSongRepository,
        SingerSongRepositoryInterface   $singerSongRepository,
        AlbumRepositoryInterface        $albumRepository,
        GenreRepositoryInterface        $genreRepository,
        SingerRepositoryInterface       $singerRepository,
        FileUploadServiceInterface      $fileUploadService,
        ImageServiceInterface           $imageService,
        ImageRepositoryInterface        $imageRepository
    )
    {
        $this->songRepository           = $songRepository;
        $this->authorRepository         = $authorRepository;
        $this->albumSongRepository      = $albumSongRepository;
        $this->genreSongRepository      = $genreSongRepository;
        $this->singerSongRepository     = $singerSongRepository;
        $this->albumRepository          = $albumRepository;
        $this->genreRepository          = $genreRepository;
        $this->singerRepository         = $singerRepository;
        $this->fileUploadService        = $fileUploadService;
        $this->imageService             = $imageService;
        $this->imageRepository          = $imageRepository;
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
        $input = $request->only(
            [
                'code','wildcard','name',
                'description','author_id',
                'link','type','sub_link','mode_play',
                'view','play','vote','publish_at'
            ]
        );

        $song = $this->songRepository->create($input);
        
        if (empty( $song )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'song_cover_image',
                $file,
                [
                    'entity_type' => 'song_cover_image',
                    'entity_id'   => $song->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($newImage)) {
                $this->songRepository->update($song, ['cover_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->songRepository->update($song, ['cover_image_id' => $newImage->id]);
                }
            }
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

        $exceptAlbums = $this->albumSongRepository->getBySongId($id)->pluck('album_id');
        $albums = $this->albumRepository->getBlankModel()->whereNotIn('id', $exceptAlbums)->get();

        $exceptGenres = $this->genreSongRepository->getBySongId($id)->pluck('genre_id');
        $genres = $this->genreRepository->getBlankModel()->whereNotIn('id', $exceptGenres)->get();

        $exceptSingers = $this->singerSongRepository->getBySongId($id)->pluck('singer_id');
        $singers = $this->singerRepository->getBlankModel()->whereNotIn('id', $exceptSingers)->get();

        return view(
            'pages.admin.' . config('view.admin') . '.songs.edit',
            [
                'isNew'   => false,
                'song'    => $song,
                'authors' => $this->authorRepository->all(),
                'albums'  => $albums,
                'genres'  => $genres,
                'singers' => $singers,
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
        $input = $request->only(
            [
                'code','wildcard','name',
                'description','author_id','link',
                'type','sub_link', 'mode_play',
                'view','play','vote','publish_at'
            ]
        );

        if ($request->hasFile('cover_image')) {
            $currentImage = $song->coverImage;
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'song_cover_image',
                $file,
                [
                    'entity_type' => 'song_cover_image',
                    'entity_id'   => $song->id,
                    'title'       => $request->input('name', ''),
                ]
            );

            if (!empty($newImage)) {
                $input['cover_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $song->coverImage;
                if( !empty($currentImage) ) {
                    $this->imageRepository->update(
                        $currentImage,
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                } else {
                    $image = $this->imageRepository->create(
                        [
                            'url'      => $imageUrl,
                            'is_local' => false
                        ]
                    );
                    $input['cover_image_id'] = $image->id;
                }
            }
        }

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

    public function addNewAlbum($id, SongRequest $request)
    {
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }

        $albums = $request->get('new-albums', []);
        foreach( $albums as $albumId ) {
            $check = $this->albumSongRepository->findByAlbumIdAndSongId($albumId, $id);
            if( empty($check) ) {
                $this->albumSongRepository->create(
                    [
                        'album_id' => $albumId,
                        'song_id'  => $id
                    ]
                );
            }
        }

        return redirect()->action('Admin\SongController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }

    public function addNewGenre($id, SongRequest $request)
    {
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }

        $genres = $request->get('new-genres', []);
        foreach( $genres as $genreId ) {
            $check = $this->genreSongRepository->findByGenreIdAndSongId($genreId, $id);
            if( empty($check) ) {
                $this->genreSongRepository->create(
                    [
                        'genre_id' => $genreId,
                        'song_id'  => $id
                    ]
                );
            }
        }

        return redirect()->action('Admin\SongController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }

    public function addNewSinger($id, SongRequest $request)
    {
        $song = $this->songRepository->find($id);
        if (empty( $song )) {
            abort(404);
        }

        $singers = $request->get('new-singers', []);
        foreach( $singers as $singerId ) {
            $check = $this->singerSongRepository->findBySingerIdAndSongId($singerId, $id);
            if( empty($check) ) {
                $this->singerSongRepository->create(
                    [
                        'singer_id' => $singerId,
                        'song_id'   => $id
                    ]
                );
            }
        }

        return redirect()->action('Admin\SongController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }

    public function search(Requests\BaseRequest $request)
    {
        $keyword = $request->get('keyword', '');
        if( $keyword == '' ) {
            return Response::response(200);
        }

        $songs = $this->songRepository->search($keyword);
        $data = [];
        foreach( $songs as $song ) {
            $tmp['id']   = $song->id;
            $tmp['text'] = $song->name . ( isset($song->singers[0]['name']) ? (' - ' . $song->singers[0]['name']) : '' );

            $data[] = $tmp;
        }

        return Response::response(200, $data);
    }
}
