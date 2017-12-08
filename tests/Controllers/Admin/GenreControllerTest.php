<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class GenreControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\GenreController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\GenreController::class);
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
        $response = $this->action('GET', 'Admin\GenreController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\GenreController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $genre = factory(\App\Models\Genre::class)->make();
        $this->action('POST', 'Admin\GenreController@store', [
                '_token' => csrf_token(),
            ] + $genre->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $genre = factory(\App\Models\Genre::class)->create();
        $this->action('GET', 'Admin\GenreController@show', [$genre->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $genre = factory(\App\Models\Genre::class)->create();

        $name = $faker->name;
        $id = $genre->id;

        $genre->name = $name;

        $this->action('PUT', 'Admin\GenreController@update', [$id], [
                '_token' => csrf_token(),
            ] + $genre->toArray());
        $this->assertResponseStatus(302);

        $newGenre = \App\Models\Genre::find($id);
        $this->assertEquals($name, $newGenre->name);
    }

    public function testDeleteModel()
    {
        $genre = factory(\App\Models\Genre::class)->create();

        $id = $genre->id;

        $this->action('DELETE', 'Admin\GenreController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkGenre = \App\Models\Genre::find($id);
        $this->assertNull($checkGenre);
    }

}
