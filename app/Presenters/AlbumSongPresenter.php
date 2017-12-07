<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Album;
use App\Models\Song;

class AlbumSongPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Album
    * */
    public function album()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_albums'), $this->entity->album_id);
            if( $cached ) {
                $album = new Album(json_decode($cached, true));
                $album['id'] = json_decode($cached, true)['id'];
                return $album;
            } else {
                $album = $this->entity->album;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_albums'), $this->entity->album_id, $album);
                return $album;
            }
        }

        $image = $this->entity->album;
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
