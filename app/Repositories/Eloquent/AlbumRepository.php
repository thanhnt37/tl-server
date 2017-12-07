<?php namespace App\Repositories\Eloquent;

use \App\Repositories\AlbumRepositoryInterface;
use \App\Models\Album;

class AlbumRepository extends SingleKeyModelRepository implements AlbumRepositoryInterface
{

    public function getBlankModel()
    {
        return new Album();
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
