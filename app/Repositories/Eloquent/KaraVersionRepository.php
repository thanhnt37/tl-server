<?php namespace App\Repositories\Eloquent;

use \App\Repositories\KaraVersionRepositoryInterface;
use \App\Models\KaraVersion;

class KaraVersionRepository extends SingleKeyModelRepository implements KaraVersionRepositoryInterface
{

    public function getBlankModel()
    {
        return new KaraVersion();
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
