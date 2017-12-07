<?php namespace Tests\Models;

use App\Models\GenreSong;
use Tests\TestCase;

class GenreSongTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\GenreSong $genreSong */
        $genreSong = new GenreSong();
        $this->assertNotNull($genreSong);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\GenreSong $genreSong */
        $genreSongModel = new GenreSong();

        $genreSongData = factory(GenreSong::class)->make();
        foreach( $genreSongData->toFillableArray() as $key => $value ) {
            $genreSongModel->$key = $value;
        }
        $genreSongModel->save();

        $this->assertNotNull(GenreSong::find($genreSongModel->id));
    }

}
