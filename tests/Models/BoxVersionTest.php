<?php namespace Tests\Models;

use App\Models\BoxVersion;
use Tests\TestCase;

class BoxVersionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\BoxVersion $boxVersion */
        $boxVersion = new BoxVersion();
        $this->assertNotNull($boxVersion);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\BoxVersion $boxVersion */
        $boxVersionModel = new BoxVersion();

        $boxVersionData = factory(BoxVersion::class)->make();
        foreach( $boxVersionData->toFillableArray() as $key => $value ) {
            $boxVersionModel->$key = $value;
        }
        $boxVersionModel->save();

        $this->assertNotNull(BoxVersion::find($boxVersionModel->id));
    }

}
