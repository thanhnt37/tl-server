<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BaseRequest;
use App\Http\Requests\PaginationRequest;
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

    public function all(PaginationRequest $request)
    {
        $page                   = $request->get('page', 1);
        $paginate['offset']     = $request->offset();
        $paginate['limit']      = $request->limit();
        $paginate['order']      = $request->order();
        $paginate['direction']  = $request->direction();
        $paginate['baseUrl']    = action( 'Admin\BoxController@index' );

        $timestamp = $request->get('timestamp', time());
        $count = $this->songRepository->countByTimestamp($timestamp);
        $songs = $this->songRepository->getByTimestamp($timestamp, $paginate['order'], $paginate['direction'], $paginate['offset'], $paginate['limit']);

        foreach( $songs as $key => $song ) {
            $songs[$key] = $song->toAPIArray();
        }

        $total = intval($count / $paginate['limit']) + (($count % $paginate['limit']) ? 1 : 0);
        $response = [
            'total_page'   => $total,
            'current_page' => $page,
            'songs'        => $songs
        ];
        
        return Response::response(200, $response);
    }

    public function detail($id)
    {
        $song = $this->songRepository->find($id);
        if (empty($song)) {
            return Response::response(20004);
        }

        $view = $song->view;
        $view = is_numeric($view) ? $view : 0;
        $song->view = $view + 1;
        $this->songRepository->save($song);

        return Response::response(200, $song->toAPIArray());
    }
}
