<?php namespace Tests\Models;

use App\Models\KaraVersion;
use Tests\TestCase;

class KaraVersionTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\KaraVersion $karaVersion */
        $karaVersion = new KaraVersion();
        $this->assertNotNull($karaVersion);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\KaraVersion $karaVersion */
        $karaVersionModel = new KaraVersion();

        $karaVersionData = factory(KaraVersion::class)->make();
        foreach( $karaVersionData->toFillableArray() as $key => $value ) {
            $karaVersionModel->$key = $value;
        }
        $karaVersionModel->save();

        $this->assertNotNull(KaraVersion::find($karaVersionModel->id));
    }

}
