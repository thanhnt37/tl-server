<?php namespace App\Repositories\Eloquent;

use \App\Repositories\StoreApplicationRepositoryInterface;
use \App\Models\StoreApplication;

class StoreApplicationRepository extends SingleKeyModelRepository implements StoreApplicationRepositoryInterface
{

    public function getBlankModel()
    {
        return new StoreApplication();
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

    public function getStoreAppWithOutCategory($catId)
    {
        $appStore = $this->all()->where('category_id', '!=', $catId);

        return $appStore;
    }
}
