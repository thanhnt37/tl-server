<?php namespace App\Repositories;

interface BoxRepositoryInterface extends AuthenticatableRepositoryInterface
{
    /**
     * find box activated by imei
     * @params  $imei
     * @return  \App\Models\Box
     * */
    public function findActivatedBoxByImei($imei);

    /**
     * Get logs with filter conditions
     *
     * @params string   $keyword
     *         int      $offset
     *         int      $limit
     * @return array    App\Models\Box
     * */
    public function getWithKeyword($keyword, $offset, $limit);

    /**
     * Count logs with filter conditions
     *
     * @params string   $keyword
     *         int      $offset
     *         int      $limit
     * @return array    App\Models\Box
     * */
    public function countWithKeyword($keyword);
}