<?php namespace App\Repositories;

interface BoxRepositoryInterface extends AuthenticatableRepositoryInterface
{
    /**
     * find box activated by imei
     * @params  $imei
     * @return  \App\Models\Box
     * */
    public function findActivatedBoxByImei($imei);
}