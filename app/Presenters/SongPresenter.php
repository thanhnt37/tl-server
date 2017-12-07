<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Author;

class SongPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Author
    * */
    public function author()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_authors'), $this->entity->author_id);
            if( $cached ) {
                $author = new Author(json_decode($cached, true));
                $author['id'] = json_decode($cached, true)['id'];
                return $author;
            } else {
                $author = $this->entity->author;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_authors'), $this->entity->author_id, $author);
                return $author;
            }
        }

        $image = $this->entity->author;
        return $image;
    }

    
}
