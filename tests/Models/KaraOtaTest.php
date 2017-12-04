<?php namespace Tests\Models;

use App\Models\KaraOta;
use Tests\TestCase;

class KaraOtaTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\KaraOta $karaOta */
        $karaOta = new KaraOta();
        $this->assertNotNull($karaOta);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\KaraOta $karaOta */
        $karaOtaModel = new KaraOta();

        $karaOtaData = factory(KaraOta::class)->make();
        foreach( $karaOtaData->toFillableArray() as $key => $value ) {
            $karaOtaModel->$key = $value;
        }
        $karaOtaModel->save();

        $this->assertNotNull(KaraOta::find($karaOtaModel->id));
    }

}
