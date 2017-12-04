<?php namespace Tests\Models;

use App\Models\Box;
use Tests\TestCase;

class BoxTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Box $box */
        $box = new Box();
        $this->assertNotNull($box);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Box $box */
        $boxModel = new Box();

        $boxData = factory(Box::class)->make();
        foreach( $boxData->toFillableArray() as $key => $value ) {
            $boxModel->$key = $value;
        }
        $boxModel->save();

        $this->assertNotNull(Box::find($boxModel->id));
    }

}
