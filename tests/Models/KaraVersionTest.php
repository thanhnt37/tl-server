<?php namespace Tests\Models;

use App\Models\AppVersion;
use Tests\TestCase;

class KaraVersionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\AppVersion $karaVersion */
        $karaVersion = new AppVersion();
        $this->assertNotNull($karaVersion);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\AppVersion $karaVersion */
        $karaVersionModel = new AppVersion();

        $karaVersionData = factory(AppVersion::class)->make();
        foreach( $karaVersionData->toFillableArray() as $key => $value ) {
            $karaVersionModel->$key = $value;
        }
        $karaVersionModel->save();

        $this->assertNotNull(AppVersion::find($karaVersionModel->id));
    }

}
