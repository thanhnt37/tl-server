<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SingerRepositoryInterface;
use \App\Models\Singer;

class SingerRepository extends SingleKeyModelRepository implements SingerRepositoryInterface
{

    public function getBlankModel()
    {
        return new Singer();
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
