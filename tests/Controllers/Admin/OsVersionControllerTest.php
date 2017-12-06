<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class OsVersionControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\OsVersionController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\OsVersionController::class);
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
        $response = $this->action('GET', 'Admin\OsVersionController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\OsVersionController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $osVersion = factory(\App\Models\OsVersion::class)->make();
        $this->action('POST', 'Admin\OsVersionController@store', [
                '_token' => csrf_token(),
            ] + $osVersion->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $osVersion = factory(\App\Models\OsVersion::class)->create();
        $this->action('GET', 'Admin\OsVersionController@show', [$osVersion->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $osVersion = factory(\App\Models\OsVersion::class)->create();

        $name = $faker->name;
        $id = $osVersion->id;

        $osVersion->name = $name;

        $this->action('PUT', 'Admin\OsVersionController@update', [$id], [
                '_token' => csrf_token(),
            ] + $osVersion->toArray());
        $this->assertResponseStatus(302);

        $newOsVersion = \App\Models\OsVersion::find($id);
        $this->assertEquals($name, $newOsVersion->name);
    }

    public function testDeleteModel()
    {
        $osVersion = factory(\App\Models\OsVersion::class)->create();

        $id = $osVersion->id;

        $this->action('DELETE', 'Admin\OsVersionController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkOsVersion = \App\Models\OsVersion::find($id);
        $this->assertNull($checkOsVersion);
    }

}
