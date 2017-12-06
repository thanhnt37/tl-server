<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SdkVersionRepositoryInterface;
use \App\Models\SdkVersion;

class SdkVersionRepository extends SingleKeyModelRepository implements SdkVersionRepositoryInterface
{

    public function getBlankModel()
    {
        return new SdkVersion();
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
