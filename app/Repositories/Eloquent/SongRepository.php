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
     * count newest song use timestamp
     *
     * @param   $timestamp
     * 
     * @return  int
     * */
    public function countByTimestamp($timestamp)
    {
        $datetime = date('Y-m-d H:i:s', $timestamp);
        $query = $this->getBlankModel();

        return $query->where('updated_at', '>', $datetime)->count();
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
    public function getByTimestamp($timestamp, $order = 'vote', $direction = 'desc', $offset = 0, $limit = 100)
    {
        $datetime = date('Y-m-d H:i:s', $timestamp);
        $query = $this->getBlankModel();

        return $query->where('updated_at', '>', $datetime)->orderBy($order, $direction)->offset($offset)->limit($limit)->get();
    }

    /**
     * Search songs by keyword
     *
     * @param   string  $keyword
     *
     * @return  mixed
     * */
    public function search($keyword)
    {
        $songModel = $this->getBlankModel();

        $songModel = $songModel->where(function ($subquery) use ($keyword)
        {
            $subquery->where('name', 'like', '%'.$keyword.'%')
                ->orWhere('wildcard', 'like', '%'.$keyword.'%')
                ->orWhere('code', 'like', '%'.$keyword.'%')
                ->orWhere('file_name', 'like', '%'.$keyword.'%')
                ->orWhere('description', 'like', '%'.$keyword.'%');
        });

        return $songModel->get();
    }
}
