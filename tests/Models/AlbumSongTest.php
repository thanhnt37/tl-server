<?php namespace Tests\Models;

use App\Models\AlbumSong;
use Tests\TestCase;

class AlbumSongTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\AlbumSong $albumSong */
        $albumSong = new AlbumSong();
        $this->assertNotNull($albumSong);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\AlbumSong $albumSong */
        $albumSongModel = new AlbumSong();

        $albumSongData = factory(AlbumSong::class)->make();
        foreach( $albumSongData->toFillableArray() as $key => $value ) {
            $albumSongModel->$key = $value;
        }
        $albumSongModel->save();

        $this->assertNotNull(AlbumSong::find($albumSongModel->id));
    }

}
