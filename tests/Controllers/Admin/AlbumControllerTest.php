<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class AlbumControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\AlbumController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\AlbumController::class);
        $this->assertNotNull($controller);
    }

    public function setUp()
    {
        parent::setUp();
        $authUser = \App\Models\AdminUser::first();
        $this->be($authUser, 'admins');
    }

    public function testGetList()
    {
        $response = $this->action('GET', 'Admin\AlbumController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\AlbumController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $album = factory(\App\Models\Album::class)->make();
        $this->action('POST', 'Admin\AlbumController@store', [
                '_token' => csrf_token(),
            ] + $album->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $album = factory(\App\Models\Album::class)->create();
        $this->action('GET', 'Admin\AlbumController@show', [$album->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $album = factory(\App\Models\Album::class)->create();

        $name = $faker->name;
        $id = $album->id;

        $album->name = $name;

        $this->action('PUT', 'Admin\AlbumController@update', [$id], [
                '_token' => csrf_token(),
            ] + $album->toArray());
        $this->assertResponseStatus(302);

        $newAlbum = \App\Models\Album::find($id);
        $this->assertEquals($name, $newAlbum->name);
    }

    public function testDeleteModel()
    {
        $album = factory(\App\Models\Album::class)->create();

        $id = $album->id;

        $this->action('DELETE', 'Admin\AlbumController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkAlbum = \App\Models\Album::find($id);
        $this->assertNull($checkAlbum);
    }

}
