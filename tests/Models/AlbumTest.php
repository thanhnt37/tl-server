<?php namespace Tests\Models;

use App\Models\Album;
use Tests\TestCase;

class AlbumTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Album $album */
        $album = new Album();
        $this->assertNotNull($album);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Album $album */
        $albumModel = new Album();

        $albumData = factory(Album::class)->make();
        foreach( $albumData->toFillableArray() as $key => $value ) {
            $albumModel->$key = $value;
        }
        $albumModel->save();

        $this->assertNotNull(Album::find($albumModel->id));
    }

}
