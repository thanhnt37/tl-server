<?php namespace Tests\Models;

use App\Models\Song;
use Tests\TestCase;

class SongTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Song $song */
        $song = new Song();
        $this->assertNotNull($song);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Song $song */
        $songModel = new Song();

        $songData = factory(Song::class)->make();
        foreach( $songData->toFillableArray() as $key => $value ) {
            $songModel->$key = $value;
        }
        $songModel->save();

        $this->assertNotNull(Song::find($songModel->id));
    }

}
