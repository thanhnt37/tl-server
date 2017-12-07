<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Singer;
use App\Models\Song;

class SingerSongPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Singer
    * */
    public function singer()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_singers'), $this->entity->singer_id);
            if( $cached ) {
                $singer = new Singer(json_decode($cached, true));
                $singer['id'] = json_decode($cached, true)['id'];
                return $singer;
            } else {
                $singer = $this->entity->singer;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_singers'), $this->entity->singer_id, $singer);
                return $singer;
            }
        }

        $image = $this->entity->singer;
        return $image;
    }

    /**
    * @return \App\Models\Song
    * */
    public function song()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_songs'), $this->entity->song_id);
            if( $cached ) {
                $song = new Song(json_decode($cached, true));
                $song['id'] = json_decode($cached, true)['id'];
                return $song;
            } else {
                $song = $this->entity->song;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_songs'), $this->entity->song_id, $song);
                return $song;
            }
        }

        $image = $this->entity->song;
        return $image;
    }

    
}
