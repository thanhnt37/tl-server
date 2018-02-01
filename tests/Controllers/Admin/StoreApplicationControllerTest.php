<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class StoreApplicationControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\StoreApplicationController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\StoreApplicationController::class);
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
        $response = $this->action('GET', 'Admin\StoreApplicationController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\StoreApplicationController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $storeApplication = factory(\App\Models\StoreApplication::class)->make();
        $this->action('POST', 'Admin\StoreApplicationController@store', [
                '_token' => csrf_token(),
            ] + $storeApplication->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $storeApplication = factory(\App\Models\StoreApplication::class)->create();
        $this->action('GET', 'Admin\StoreApplicationController@show', [$storeApplication->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $storeApplication = factory(\App\Models\StoreApplication::class)->create();

        $name = $faker->name;
        $id = $storeApplication->id;

        $storeApplication->name = $name;

        $this->action('PUT', 'Admin\StoreApplicationController@update', [$id], [
                '_token' => csrf_token(),
            ] + $storeApplication->toArray());
        $this->assertResponseStatus(302);

        $newStoreApplication = \App\Models\StoreApplication::find($id);
        $this->assertEquals($name, $newStoreApplication->name);
    }

    public function testDeleteModel()
    {
        $storeApplication = factory(\App\Models\StoreApplication::class)->create();

        $id = $storeApplication->id;

        $this->action('DELETE', 'Admin\StoreApplicationController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkStoreApplication = \App\Models\StoreApplication::find($id);
        $this->assertNull($checkStoreApplication);
    }

}
