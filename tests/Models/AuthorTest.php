<?php namespace Tests\Models;

use App\Models\Author;
use Tests\TestCase;

class AuthorTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Author $author */
        $author = new Author();
        $this->assertNotNull($author);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Author $author */
        $authorModel = new Author();

        $authorData = factory(Author::class)->make();
        foreach( $authorData->toFillableArray() as $key => $value ) {
            $authorModel->$key = $value;
        }
        $authorModel->save();

        $this->assertNotNull(Author::find($authorModel->id));
    }

}
