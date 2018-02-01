<?php namespace App\Repositories\Eloquent;

use \App\Repositories\CategoryRepositoryInterface;
use \App\Models\Category;

class CategoryRepository extends SingleKeyModelRepository implements CategoryRepositoryInterface
{

    public function getBlankModel()
    {
        return new Category();
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
