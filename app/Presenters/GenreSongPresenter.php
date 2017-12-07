<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Genre;
use App\Models\Song;

class GenreSongPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Genre
    * */
    public function genre()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_genres'), $this->entity->genre_id);
            if( $cached ) {
                $genre = new Genre(json_decode($cached, true));
                $genre['id'] = json_decode($cached, true)['id'];
                return $genre;
            } else {
                $genre = $this->entity->genre;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_genres'), $this->entity->genre_id, $genre);
                return $genre;
            }
        }

        $image = $this->entity->genre;
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
