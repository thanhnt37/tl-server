<?php namespace App\Repositories\Eloquent;

use \App\Repositories\AuthorRepositoryInterface;
use \App\Models\Author;

class AuthorRepository extends SingleKeyModelRepository implements AuthorRepositoryInterface
{

    public function getBlankModel()
    {
        return new Author();
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
