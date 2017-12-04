<?php

namespace App\Presenters;

use Illuminate\Support\Facades\Redis;
use App\Models\KaraVersion;

class KaraOtaPresenter extends BasePresenter
{
    protected $multilingualFields = [];

    protected $imageFields = [];

    /**
    * @return \App\Models\KaraVersion
    * */
    public function karaVersion()
    {
        if( \CacheHelper::cacheRedisEnabled() ) {
            $cached = Redis::hget(\CacheHelper::generateCacheKey('hash_kara_versions'), $this->entity->kara_version_id);
            if( $cached ) {
                $karaVersion = new KaraVersion(json_decode($cached, true));
                $karaVersion['id'] = json_decode($cached, true)['id'];
                return $karaVersion;
            } else {
                $karaVersion = $this->entity->karaVersion;
                Redis::hsetnx(\CacheHelper::generateCacheKey('hash_kara_versions'), $this->entity->kara_version_id, $karaVersion);
                return $karaVersion;
            }
        }

        $image = $this->entity->karaVersion;
        return $image;
    }

    
}