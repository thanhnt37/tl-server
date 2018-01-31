<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Image;
use App\Models\Image;
use App\Models\ApkPackage;
use App\Models\Category;
use App\Models\Developer;

class StoreApplicationPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = ['icon_image','background_image'];

    /**
    * @return \App\Models\Image
    * */
    public function iconImage()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_images'), $this->entity->icon_image_id);
            if( $cached ) {
                $image = new Image(json_decode($cached, true));
                $image['id'] = json_decode($cached, true)['id'];
                return $image;
            } else {
                $image = $this->entity->iconImage;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_images'), $this->entity->icon_image_id, $image);
                return $image;
            }
        }

        $image = $this->entity->iconImage;
        return $image;
    }

    /**
    * @return \App\Models\Image
    * */
    public function backgroundImage()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_images'), $this->entity->background_image_id);
            if( $cached ) {
                $image = new Image(json_decode($cached, true));
                $image['id'] = json_decode($cached, true)['id'];
                return $image;
            } else {
                $image = $this->entity->backgroundImage;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_images'), $this->entity->background_image_id, $image);
                return $image;
            }
        }

        $image = $this->entity->backgroundImage;
        return $image;
    }

    /**
    * @return \App\Models\ApkPackage
    * */
    public function apkPackage()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_apk_packages'), $this->entity->apk_package_id);
            if( $cached ) {
                $apkPackage = new ApkPackage(json_decode($cached, true));
                $apkPackage['id'] = json_decode($cached, true)['id'];
                return $apkPackage;
            } else {
                $apkPackage = $this->entity->apkPackage;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_apk_packages'), $this->entity->apk_package_id, $apkPackage);
                return $apkPackage;
            }
        }

        $image = $this->entity->apkPackage;
        return $image;
    }

    /**
    * @return \App\Models\Category
    * */
    public function category()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_categories'), $this->entity->category_id);
            if( $cached ) {
                $category = new Category(json_decode($cached, true));
                $category['id'] = json_decode($cached, true)['id'];
                return $category;
            } else {
                $category = $this->entity->category;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_categories'), $this->entity->category_id, $category);
                return $category;
            }
        }

        $image = $this->entity->category;
        return $image;
    }

    /**
    * @return \App\Models\Developer
    * */
    public function developer()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_developers'), $this->entity->developer_id);
            if( $cached ) {
                $developer = new Developer(json_decode($cached, true));
                $developer['id'] = json_decode($cached, true)['id'];
                return $developer;
            } else {
                $developer = $this->entity->developer;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_developers'), $this->entity->developer_id, $developer);
                return $developer;
            }
        }

        $image = $this->entity->developer;
        return $image;
    }

    
}
