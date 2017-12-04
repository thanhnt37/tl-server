<?php namespace App\Repositories\Eloquent;

use \App\Repositories\KaraOtaRepositoryInterface;
use \App\Models\KaraOta;

class KaraOtaRepository extends SingleKeyModelRepository implements KaraOtaRepositoryInterface
{

    public function getBlankModel()
    {
        return new KaraOta();
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
