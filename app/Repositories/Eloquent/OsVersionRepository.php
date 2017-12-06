<?php namespace App\Repositories\Eloquent;

use \App\Repositories\OsVersionRepositoryInterface;
use \App\Models\OsVersion;

class OsVersionRepository extends SingleKeyModelRepository implements OsVersionRepositoryInterface
{

    public function getBlankModel()
    {
        return new OsVersion();
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
