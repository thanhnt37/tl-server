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

}
