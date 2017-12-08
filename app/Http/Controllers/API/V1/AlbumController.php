<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\AlbumRepositoryInterface;

class AlbumController extends Controller
{
    /** @var \App\Repositories\AlbumRepositoryInterface */
    protected $albumRepository;

    public function __construct(
        AlbumRepositoryInterface    $albumRepository
    ) {
        $this->albumRepository      = $albumRepository;
    }

    public function lists(BaseRequest $request)
    {
        $limit = $request->get('limit', 10);
        $limit = is_numeric($limit) ? $limit : 10;

        $albums = $this->albumRepository->get('vote', 'desc', 0, $limit);
        foreach( $albums as $key => $album ) {
            unset($albums[$key]['deleted_at']);
            unset($albums[$key]['created_at']);
            unset($albums[$key]['updated_at']);
        }
        return Response::response(200, $albums);
    }

    public function detail($id)
    {
        $album = $this->albumRepository->find($id);
        if (empty($album)) {
            return Response::response(20004);
        }

        $songs = $album->songs;
        foreach( $songs as $key => $song ) {
            $name = isset($song->author->name) ? $song->author->name : 'Unknown';
            $songs[$key]['author_name'] = $name;

            unset($songs[$key]['author']);
            unset($songs[$key]['author_id']);
            unset($songs[$key]['deleted_at']);
            unset($songs[$key]['updated_at']);
        }

        unset($album['updated_at']);
        unset($album['deleted_at']);

        $album['songs'] = $songs;
        return Response::response(200, $album);
    }
}
