<?php namespace Tests\Models;

use App\Models\Developer;
use Tests\TestCase;

class DeveloperTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Developer $developer */
        $developer = new Developer();
        $this->assertNotNull($developer);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Developer $developer */
        $developerModel = new Developer();

        $developerData = factory(Developer::class)->make();
        foreach( $developerData->toFillableArray() as $key => $value ) {
            $developerModel->$key = $value;
        }
        $developerModel->save();

        $this->assertNotNull(Developer::find($developerModel->id));
    }

}
