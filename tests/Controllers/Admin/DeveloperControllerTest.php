<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class DeveloperControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\DeveloperController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\DeveloperController::class);
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
        $response = $this->action('GET', 'Admin\DeveloperController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\DeveloperController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $developer = factory(\App\Models\Developer::class)->make();
        $this->action('POST', 'Admin\DeveloperController@store', [
                '_token' => csrf_token(),
            ] + $developer->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $developer = factory(\App\Models\Developer::class)->create();
        $this->action('GET', 'Admin\DeveloperController@show', [$developer->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $developer = factory(\App\Models\Developer::class)->create();

        $name = $faker->name;
        $id = $developer->id;

        $developer->name = $name;

        $this->action('PUT', 'Admin\DeveloperController@update', [$id], [
                '_token' => csrf_token(),
            ] + $developer->toArray());
        $this->assertResponseStatus(302);

        $newDeveloper = \App\Models\Developer::find($id);
        $this->assertEquals($name, $newDeveloper->name);
    }

    public function testDeleteModel()
    {
        $developer = factory(\App\Models\Developer::class)->create();

        $id = $developer->id;

        $this->action('DELETE', 'Admin\DeveloperController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkDeveloper = \App\Models\Developer::find($id);
        $this->assertNull($checkDeveloper);
    }

}
