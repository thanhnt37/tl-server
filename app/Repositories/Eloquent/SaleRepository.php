<?php namespace App\Repositories\Eloquent;

use \App\Repositories\SaleRepositoryInterface;
use \App\Models\Sale;

class SaleRepository extends SingleKeyModelRepository implements SaleRepositoryInterface
{

    public function getBlankModel()
    {
        return new Sale();
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

}
