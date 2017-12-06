<?php namespace Tests\Models;

use App\Models\SdkVersion;
use Tests\TestCase;

class SdkVersionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\SdkVersion $sdkVersion */
        $sdkVersion = new SdkVersion();
        $this->assertNotNull($sdkVersion);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\SdkVersion $sdkVersion */
        $sdkVersionModel = new SdkVersion();

        $sdkVersionData = factory(SdkVersion::class)->make();
        foreach( $sdkVersionData->toFillableArray() as $key => $value ) {
            $sdkVersionModel->$key = $value;
        }
        $sdkVersionModel->save();

        $this->assertNotNull(SdkVersion::find($sdkVersionModel->id));
    }

}
