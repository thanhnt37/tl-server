<?php namespace Tests\Models;

use App\Models\Genre;
use Tests\TestCase;

class GenreTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Genre $genre */
        $genre = new Genre();
        $this->assertNotNull($genre);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Genre $genre */
        $genreModel = new Genre();

        $genreData = factory(Genre::class)->make();
        foreach( $genreData->toFillableArray() as $key => $value ) {
            $genreModel->$key = $value;
        }
        $genreModel->save();

        $this->assertNotNull(Genre::find($genreModel->id));
    }

}
