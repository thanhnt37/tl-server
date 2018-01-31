<?php namespace App\Repositories\Eloquent;

use \App\Repositories\KaraVersionRepositoryInterface;
use \App\Models\AppVersion;

class KaraVersionRepository extends SingleKeyModelRepository implements KaraVersionRepositoryInterface
{

    public function getBlankModel()
    {
        return new AppVersion();
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
