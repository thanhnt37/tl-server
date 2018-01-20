<?php namespace App\Repositories\Eloquent;

use \App\Repositories\ApplicationRepositoryInterface;
use \App\Models\Application;

class ApplicationRepository extends SingleKeyModelRepository implements ApplicationRepositoryInterface
{

    public function getBlankModel()
    {
        return new Application();
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
