<?php namespace Tests\Models;

use App\Models\StoreApplication;
use Tests\TestCase;

class StoreApplicationTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\StoreApplication $storeApplication */
        $storeApplication = new StoreApplication();
        $this->assertNotNull($storeApplication);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\StoreApplication $storeApplication */
        $storeApplicationModel = new StoreApplication();

        $storeApplicationData = factory(StoreApplication::class)->make();
        foreach( $storeApplicationData->toFillableArray() as $key => $value ) {
            $storeApplicationModel->$key = $value;
        }
        $storeApplicationModel->save();

        $this->assertNotNull(StoreApplication::find($storeApplicationModel->id));
    }

}
