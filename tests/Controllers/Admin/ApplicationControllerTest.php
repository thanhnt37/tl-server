<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class ApplicationControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\ApplicationController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\ApplicationController::class);
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
        $response = $this->action('GET', 'Admin\ApplicationController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\ApplicationController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $application = factory(\App\Models\Application::class)->make();
        $this->action('POST', 'Admin\ApplicationController@store', [
                '_token' => csrf_token(),
            ] + $application->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $application = factory(\App\Models\Application::class)->create();
        $this->action('GET', 'Admin\ApplicationController@show', [$application->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $application = factory(\App\Models\Application::class)->create();

        $name = $faker->name;
        $id = $application->id;

        $application->name = $name;

        $this->action('PUT', 'Admin\ApplicationController@update', [$id], [
                '_token' => csrf_token(),
            ] + $application->toArray());
        $this->assertResponseStatus(302);

        $newApplication = \App\Models\Application::find($id);
        $this->assertEquals($name, $newApplication->name);
    }

    public function testDeleteModel()
    {
        $application = factory(\App\Models\Application::class)->create();

        $id = $application->id;

        $this->action('DELETE', 'Admin\ApplicationController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkApplication = \App\Models\Application::find($id);
        $this->assertNull($checkApplication);
    }

}
