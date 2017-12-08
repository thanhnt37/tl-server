<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SingerSongRepositoryInterface;
use \App\Models\SingerSong;

class SingerSongRepository extends SingleKeyModelRepository implements SingerSongRepositoryInterface
{

    public function getBlankModel()
    {
        return new SingerSong();
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
