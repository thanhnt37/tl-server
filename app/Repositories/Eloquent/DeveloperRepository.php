<?php namespace App\Repositories\Eloquent;

use \App\Repositories\DeveloperRepositoryInterface;
use \App\Models\Developer;

class DeveloperRepository extends SingleKeyModelRepository implements DeveloperRepositoryInterface
{

    public function getBlankModel()
    {
        return new Developer();
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
