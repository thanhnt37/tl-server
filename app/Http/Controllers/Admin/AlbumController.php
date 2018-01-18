<?php namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Repositories\AlbumRepositoryInterface;
use App\Http\Requests\Admin\AlbumRequest;
use App\Http\Requests\PaginationRequest;
use App\Repositories\AlbumSongRepositoryInterface;
use App\Repositories\SongRepositoryInterface;
use App\Services\FileUploadServiceInterface;
use App\Services\ImageServiceInterface;
use App\Repositories\ImageRepositoryInterface;

class AlbumController extends Controller
{
    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $albumRepository;

    /** @var \App\Repositories\AlbumSongRepositoryInterface */
    protected $albumSongRepository;

    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    /** @var \App\Services\FileUploadServiceInterface */
    protected $fileUploadService;

    /** @var  \App\Services\ImageServiceInterface */
    protected $imageService;

    /** @var  \App\Repositories\ImageRepositoryInterface */
    protected $imageRepository;

    public function __construct(
        AlbumRepositoryInterface        $albumRepository,
        AlbumSongRepositoryInterface    $albumSongRepository,
        SongRepositoryInterface         $songRepository,
        FileUploadServiceInterface      $fileUploadService,
        ImageServiceInterface           $imageService,
        ImageRepositoryInterface        $imageRepository
    )
    {
        $this->albumRepository          = $albumRepository;
        $this->albumSongRepository      = $albumSongRepository;
        $this->songRepository           = $songRepository;
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
        $input = $request->only(['name','description','vote','publish_at']);

        $album = $this->albumRepository->create($input);

        if (empty( $album )) {
            return redirect()->back()->withErrors(trans('admin.errors.general.save_failed'));
        }

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'album_cover_image',
                $file,
                [
                    'entity_type' => 'album_cover_image',
                    'entity_id'   => $album->id,
                    'title'       => $album->name,
                ]
            );

            if (!empty($newImage)) {
                $this->songRepository->update($album, ['cover_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('cover_image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->songRepository->update($album, ['cover_image_id' => $newImage->id]);
                }
            }
        }

        if ($request->hasFile('background_image')) {
            $file = $request->file('background_image');

            $newImage = $this->fileUploadService->upload(
                'album_background_image',
                $file,
                [
                    'entity_type' => 'album_background_image',
                    'entity_id'   => $album->id,
                    'title'       => $album->name,
                ]
            );

            if (!empty($newImage)) {
                $this->songRepository->update($album, ['background_image_id' => $newImage->id]);
            }
        } else {
            $imageUrl = $request->get('background_image_url', '');
            if( $imageUrl != '' ) {
                $newImage = $this->imageRepository->create(
                    [
                        'url'      => $imageUrl,
                        'is_local' => false
                    ]
                );

                if (!empty($newImage)) {
                    $this->songRepository->update($album, ['background_image_id' => $newImage->id]);
                }
            }
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

        $exceptSongs = $this->albumSongRepository->getByAlbumId($id)->pluck('song_id');
//        $songs = $this->songRepository->getBlankModel()->whereNotIn('id', $exceptSongs)->get();

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

        $input = $request->only(['name','description','vote','publish_at']);

        if ($request->hasFile('cover_image')) {
            $currentImage = $album->coverImage;
            $file = $request->file('cover_image');

            $newImage = $this->fileUploadService->upload(
                'album_cover_image',
                $file,
                [
                    'entity_type' => 'album_cover_image',
                    'entity_id'   => $album->id,
                    'title'       => $album->name,
                ]
            );

            if (!empty($newImage)) {
                $input['cover_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('cover_image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $album->coverImage;
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

        if ($request->hasFile('background_image')) {
            $currentImage = $album->backgroundImage;
            $file = $request->file('background_image');

            $newImage = $this->fileUploadService->upload(
                'album_background_image',
                $file,
                [
                    'entity_type' => 'album_background_image',
                    'entity_id'   => $album->id,
                    'title'       => $album->name,
                ]
            );

            if (!empty($newImage)) {
                $input['background_image_id'] = $newImage->id;

                if (!empty($currentImage)) {
                    $this->fileUploadService->delete($currentImage);
                }
            }
        } else {
            $imageUrl = $request->get('background_image_url', '');
            if( $imageUrl != '' ) {
                $currentImage = $album->backgroundImage;
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
                    $input['background_image_id'] = $image->id;
                }
            }
        }
        
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Response
     */
    public function deleteSong($albumId, $songId)
    {
        /** @var \App\Models\AlbumSong $albumSong */
        $albumSong = $this->albumSongRepository->findByAlbumIdAndSongId($albumId, $songId);
        if (empty( $albumSong )) {
            abort(404);
        }
        $this->albumSongRepository->delete($albumSong);

        return redirect()->back()->with('message-success', trans('admin.messages.general.delete_success'));
    }

    public function addNewSong($id, AlbumRequest $request)
    {
        $album = $this->albumRepository->find($id);
        if (empty( $album )) {
            abort(404);
        }

        $songs = $request->get('new-songs', []);
        foreach( $songs as $songId ) {
            $check = $this->albumSongRepository->findByAlbumIdAndSongId($album->id, $songId);
            if( empty($check) ) {
                $this->albumSongRepository->create(
                    [
                        'album_id' => $album->id,
                        'song_id'  => $songId
                    ]
                );
            }
        }

        return redirect()->action('Admin\AlbumController@show', [$id])->with('message-success', trans('admin.messages.general.update_success'));
    }
}
