<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class SongControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\SongController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\SongController::class);
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
        $response = $this->action('GET', 'Admin\SongController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\SongController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $song = factory(\App\Models\Song::class)->make();
        $this->action('POST', 'Admin\SongController@store', [
                '_token' => csrf_token(),
            ] + $song->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $song = factory(\App\Models\Song::class)->create();
        $this->action('GET', 'Admin\SongController@show', [$song->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $song = factory(\App\Models\Song::class)->create();

        $name = $faker->name;
        $id = $song->id;

        $song->name = $name;

        $this->action('PUT', 'Admin\SongController@update', [$id], [
                '_token' => csrf_token(),
            ] + $song->toArray());
        $this->assertResponseStatus(302);

        $newSong = \App\Models\Song::find($id);
        $this->assertEquals($name, $newSong->name);
    }

    public function testDeleteModel()
    {
        $song = factory(\App\Models\Song::class)->create();

        $id = $song->id;

        $this->action('DELETE', 'Admin\SongController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkSong = \App\Models\Song::find($id);
        $this->assertNull($checkSong);
    }

}
