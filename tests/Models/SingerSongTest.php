<?php namespace Tests\Models;

use App\Models\SingerSong;
use Tests\TestCase;

class SingerSongTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\SingerSong $singerSong */
        $singerSong = new SingerSong();
        $this->assertNotNull($singerSong);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\SingerSong $singerSong */
        $singerSongModel = new SingerSong();

        $singerSongData = factory(SingerSong::class)->make();
        foreach( $singerSongData->toFillableArray() as $key => $value ) {
            $singerSongModel->$key = $value;
        }
        $singerSongModel->save();

        $this->assertNotNull(SingerSong::find($singerSongModel->id));
    }

}
