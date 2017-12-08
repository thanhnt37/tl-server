<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class AuthorControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\AuthorController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\AuthorController::class);
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
        $response = $this->action('GET', 'Admin\AuthorController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\AuthorController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $author = factory(\App\Models\Author::class)->make();
        $this->action('POST', 'Admin\AuthorController@store', [
                '_token' => csrf_token(),
            ] + $author->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $author = factory(\App\Models\Author::class)->create();
        $this->action('GET', 'Admin\AuthorController@show', [$author->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $author = factory(\App\Models\Author::class)->create();

        $name = $faker->name;
        $id = $author->id;

        $author->name = $name;

        $this->action('PUT', 'Admin\AuthorController@update', [$id], [
                '_token' => csrf_token(),
            ] + $author->toArray());
        $this->assertResponseStatus(302);

        $newAuthor = \App\Models\Author::find($id);
        $this->assertEquals($name, $newAuthor->name);
    }

    public function testDeleteModel()
    {
        $author = factory(\App\Models\Author::class)->create();

        $id = $author->id;

        $this->action('DELETE', 'Admin\AuthorController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkAuthor = \App\Models\Author::find($id);
        $this->assertNull($checkAuthor);
    }

}
