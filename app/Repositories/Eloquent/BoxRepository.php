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

    /**
     * find box activated by imei
     * @params  $imei
     * @return  \App\Models\Box
     * */
    public function findActivatedBoxByImei($imei)
    {
        $box = $this->findByImei($imei);
        return $box->is_activated ? $box : null;
    }
}
