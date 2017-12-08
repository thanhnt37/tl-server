<?php namespace App\Repositories\Eloquent;

use \App\Repositories\GenreRepositoryInterface;
use \App\Models\Genre;

class GenreRepository extends SingleKeyModelRepository implements GenreRepositoryInterface
{

    public function getBlankModel()
    {
        return new Genre();
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
