<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SongRepositoryInterface;
use \App\Models\Song;

class SongRepository extends SingleKeyModelRepository implements SongRepositoryInterface
{

    public function getBlankModel()
    {
        return new Song();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    /**
     * get newest song use timestamp
     *
     * @param   $timestamp
     *          $order
     *          $direction
     * 
     * @return  mixed
     * */
    public function getAllSongByTimestamp($timestamp, $order = 'vote', $direction = 'desc')
    {
        $datetime = date('Y-m-d H:i:s', $timestamp);
        $query = $this->getBlankModel();

        return $query->where('created_at', '>', $datetime)->orderBy($order, $direction)->get();
    }
}
