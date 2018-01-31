<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class AppVersionControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\AppVersionController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\AppVersionController::class);
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
        $response = $this->action('GET', 'Admin\AppVersionController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\AppVersionController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $karaVersion = factory(\App\Models\AppVersion::class)->make();
        $this->action('POST', 'Admin\AppVersionController@store', [
                '_token' => csrf_token(),
            ] + $karaVersion->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $karaVersion = factory(\App\Models\AppVersion::class)->create();
        $this->action('GET', 'Admin\AppVersionController@show', [$karaVersion->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $karaVersion = factory(\App\Models\AppVersion::class)->create();

        $name = $faker->name;
        $id = $karaVersion->id;

        $karaVersion->name = $name;

        $this->action('PUT', 'Admin\AppVersionController@update', [$id], [
                '_token' => csrf_token(),
            ] + $karaVersion->toArray());
        $this->assertResponseStatus(302);

        $newKaraVersion = \App\Models\AppVersion::find($id);
        $this->assertEquals($name, $newKaraVersion->name);
    }

    public function testDeleteModel()
    {
        $karaVersion = factory(\App\Models\AppVersion::class)->create();

        $id = $karaVersion->id;

        $this->action('DELETE', 'Admin\AppVersionController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkKaraVersion = \App\Models\AppVersion::find($id);
        $this->assertNull($checkKaraVersion);
    }

}
