<?php namespace Tests\Models;

use App\Models\Singer;
use Tests\TestCase;

class SingerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Singer $singer */
        $singer = new Singer();
        $this->assertNotNull($singer);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Singer $singer */
        $singerModel = new Singer();

        $singerData = factory(Singer::class)->make();
        foreach( $singerData->toFillableArray() as $key => $value ) {
            $singerModel->$key = $value;
        }
        $singerModel->save();

        $this->assertNotNull(Singer::find($singerModel->id));
    }

}
