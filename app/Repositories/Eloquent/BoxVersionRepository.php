<?php namespace App\Repositories\Eloquent;

use \App\Repositories\BoxVersionRepositoryInterface;
use \App\Models\BoxVersion;

class BoxVersionRepository extends SingleKeyModelRepository implements BoxVersionRepositoryInterface
{

    public function getBlankModel()
    {
        return new BoxVersion();
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
