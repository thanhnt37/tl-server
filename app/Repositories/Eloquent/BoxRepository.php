<?php namespace App\Repositories\Eloquent;

use \App\Repositories\BoxRepositoryInterface;
use \App\Models\Box;

class BoxRepository extends AuthenticatableRepository implements BoxRepositoryInterface
{

    public function getBlankModel()
    {
        return new Box();
    }

    public function rules()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
        ];
    }

    /**
     * find box activated by imei
     * @params  $imei
     * @return  \App\Models\Box
     * */
    public function findActivatedBoxByImei($imei)
    {
        $box = $this->findByImei($imei);
        if( empty($box) || $box->is_blocked ) {
            return null;
        }
        
        return $box->is_activated ? $box : null;
    }

    /**
     * Get logs with filter conditions
     *
     * @params string   $keyword
     *         int      $offset
     *         int      $limit
     * @return array    App\Models\Box
     * */
    public function getWithKeyword($keyword, $offset, $limit)
    {
        $model = $this->getBlankModel();

        $model = $model->where(function ($subquery) use ($keyword) {
            $subquery->where('imei', 'like', '%'.$keyword.'%')
                ->orWhere('serial', 'like', '%'.$keyword.'%');
        });

        return $model->offset($offset)->limit($limit)->get();
    }

    /**
     * Count logs with filter conditions
     *
     * @params string   $keyword
     *         int      $offset
     *         int      $limit
     * @return array    App\Models\Box
     * */
    public function countWithKeyword($keyword)
    {
        $model = $this->getBlankModel();

        $model = $model->where(function ($subquery) use ($keyword) {
            $subquery->where('imei', 'like', '%'.$keyword.'%')
                ->orWhere('serial', 'like', '%'.$keyword.'%');
        });

        return $model->count();
    }
}
