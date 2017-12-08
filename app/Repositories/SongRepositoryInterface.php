<?php namespace App\Repositories;

interface SongRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * get newest song use timestamp
     *
     * @param   $timestamp
     *          $order
     *          $direction
     *
     * @return  mixed
     * */
    public function getAllSongByTimestamp($timestamp, $order = 'vote', $direction = 'desc');
}