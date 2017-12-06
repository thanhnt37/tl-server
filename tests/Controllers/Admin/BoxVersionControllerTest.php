<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class BoxVersionControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\BoxVersionController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\BoxVersionController::class);
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
        $response = $this->action('GET', 'Admin\BoxVersionController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\BoxVersionController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $boxVersion = factory(\App\Models\BoxVersion::class)->make();
        $this->action('POST', 'Admin\BoxVersionController@store', [
                '_token' => csrf_token(),
            ] + $boxVersion->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $boxVersion = factory(\App\Models\BoxVersion::class)->create();
        $this->action('GET', 'Admin\BoxVersionController@show', [$boxVersion->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $boxVersion = factory(\App\Models\BoxVersion::class)->create();

        $name = $faker->name;
        $id = $boxVersion->id;

        $boxVersion->name = $name;

        $this->action('PUT', 'Admin\BoxVersionController@update', [$id], [
                '_token' => csrf_token(),
            ] + $boxVersion->toArray());
        $this->assertResponseStatus(302);

        $newBoxVersion = \App\Models\BoxVersion::find($id);
        $this->assertEquals($name, $newBoxVersion->name);
    }

    public function testDeleteModel()
    {
        $boxVersion = factory(\App\Models\BoxVersion::class)->create();

        $id = $boxVersion->id;

        $this->action('DELETE', 'Admin\BoxVersionController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkBoxVersion = \App\Models\BoxVersion::find($id);
        $this->assertNull($checkBoxVersion);
    }

}
