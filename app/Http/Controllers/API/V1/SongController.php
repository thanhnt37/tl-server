<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Responses\API\V1\Response;
use App\Repositories\SongRepositoryInterface;

class SongController extends Controller
{
    /** @var \App\Repositories\SongRepositoryInterface */
    protected $songRepository;

    public function __construct(
        SongRepositoryInterface     $songRepository
    ) {
        $this->songRepository       = $songRepository;
    }

    public function getAllSongs(BaseRequest $request)
    {
        $timestamp = $request->get('timestamp', time());
        $songs = $this->songRepository->getAllSongByTimestamp($timestamp, 'vote', 'desc');

        foreach( $songs as $key => $song ) {
            $name = isset($song->author->name) ? $song->author->name : 'Unknown';
            $songs[$key]['author_name'] = $name;

            unset($songs[$key]['author']);
            unset($songs[$key]['author_id']);
            unset($songs[$key]['deleted_at']);
            unset($songs[$key]['updated_at']);
        }
        
        return Response::response(200, $songs);
    }
}
