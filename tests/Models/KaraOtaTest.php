<?php namespace Tests\Models;

use App\Models\AppOta;
use Tests\TestCase;

class KaraOtaTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\AppOta $karaOta */
        $karaOta = new AppOta();
        $this->assertNotNull($karaOta);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\AppOta $karaOta */
        $karaOtaModel = new AppOta();

        $karaOtaData = factory(AppOta::class)->make();
        foreach( $karaOtaData->toFillableArray() as $key => $value ) {
            $karaOtaModel->$key = $value;
        }
        $karaOtaModel->save();

        $this->assertNotNull(AppOta::find($karaOtaModel->id));
    }

}
