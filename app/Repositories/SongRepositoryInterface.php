<?php namespace App\Repositories;

interface SongRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * get newest song use timestamp
     *
     * @param   $timestamp
     *          $order
     *          $direction
     *          $offset
     *          $limit
     *
     * @return  mixed
     * */
    public function getByTimestamp($timestamp, $order = 'vote', $direction = 'desc', $offset = 0, $limit = 100);

    /**
     * get newest song use timestamp
     *
     * @param   $timestamp
     *
     * @return  mixed
     * */
    public function countByTimestamp($timestamp);
}