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

    public function all(BaseRequest $request)
    {
        $timestamp = $request->get('timestamp', time());
        $songs = $this->songRepository->getAllSongByTimestamp($timestamp, 'vote', 'desc');
        
        foreach( $songs as $key => $song ) {
            $songs[$key] = $song->toAPIArray();
        }
        
        return Response::response(200, $songs);
    }

    public function detail($id)
    {

    }
}
