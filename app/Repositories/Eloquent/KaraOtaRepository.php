<?php namespace App\Repositories\Eloquent;

use \App\Repositories\KaraOtaRepositoryInterface;
use \App\Models\AppOta;

class KaraOtaRepository extends SingleKeyModelRepository implements KaraOtaRepositoryInterface
{

    public function getBlankModel()
    {
        return new AppOta();
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
