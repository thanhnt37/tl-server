<?php namespace Tests\Models;

use App\Models\Sale;
use Tests\TestCase;

class SaleTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Sale $sale */
        $sale = new Sale();
        $this->assertNotNull($sale);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Sale $sale */
        $saleModel = new Sale();

        $saleData = factory(Sale::class)->make();
        foreach( $saleData->toFillableArray() as $key => $value ) {
            $saleModel->$key = $value;
        }
        $saleModel->save();

        $this->assertNotNull(Sale::find($saleModel->id));
    }

}
