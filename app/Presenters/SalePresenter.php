<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\Customer;
use App\Models\Box;

class SalePresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\Customer
    * */
    public function customer()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_customers'), $this->entity->customer_id);
            if( $cached ) {
                $customer = new Customer(json_decode($cached, true));
                $customer['id'] = json_decode($cached, true)['id'];
                return $customer;
            } else {
                $customer = $this->entity->customer;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_customers'), $this->entity->customer_id, $customer);
                return $customer;
            }
        }

        $image = $this->entity->customer;
        return $image;
    }

    /**
    * @return \App\Models\Box
    * */
    public function box()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_boxes'), $this->entity->box_id);
            if( $cached ) {
                $box = new Box(json_decode($cached, true));
                $box['id'] = json_decode($cached, true)['id'];
                return $box;
            } else {
                $box = $this->entity->box;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_boxes'), $this->entity->box_id, $box);
                return $box;
            }
        }

        $image = $this->entity->box;
        return $image;
    }

    
}
