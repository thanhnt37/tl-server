<?php namespace App\Repositories\Eloquent;

use \App\Repositories\GenreSongRepositoryInterface;
use \App\Models\GenreSong;

class GenreSongRepository extends SingleKeyModelRepository implements GenreSongRepositoryInterface
{

    public function getBlankModel()
    {
        return new GenreSong();
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
