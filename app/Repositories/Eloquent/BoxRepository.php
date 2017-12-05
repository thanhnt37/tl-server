<?php namespace App\Repositories\Eloquent;

use \App\Repositories\BoxRepositoryInterface;
use \App\Models\Box;

class BoxRepository extends AuthenticatableRepository implements BoxRepositoryInterface
{

    public function getBlankModel()
    {
        return new Box();
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
