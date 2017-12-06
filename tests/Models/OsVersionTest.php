<?php namespace Tests\Models;

use App\Models\OsVersion;
use Tests\TestCase;

class OsVersionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\OsVersion $osVersion */
        $osVersion = new OsVersion();
        $this->assertNotNull($osVersion);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\OsVersion $osVersion */
        $osVersionModel = new OsVersion();

        $osVersionData = factory(OsVersion::class)->make();
        foreach( $osVersionData->toFillableArray() as $key => $value ) {
            $osVersionModel->$key = $value;
        }
        $osVersionModel->save();

        $this->assertNotNull(OsVersion::find($osVersionModel->id));
    }

}
