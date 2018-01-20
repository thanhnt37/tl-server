<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class AppOtaControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\AppOtaController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\AppOtaController::class);
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
        $response = $this->action('GET', 'Admin\AppOtaController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\AppOtaController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $karaOta = factory(\App\Models\KaraOta::class)->make();
        $this->action('POST', 'Admin\AppOtaController@store', [
                '_token' => csrf_token(),
            ] + $karaOta->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $karaOta = factory(\App\Models\KaraOta::class)->create();
        $this->action('GET', 'Admin\AppOtaController@show', [$karaOta->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $karaOta = factory(\App\Models\KaraOta::class)->create();

        $name = $faker->name;
        $id = $karaOta->id;

        $karaOta->name = $name;

        $this->action('PUT', 'Admin\AppOtaController@update', [$id], [
                '_token' => csrf_token(),
            ] + $karaOta->toArray());
        $this->assertResponseStatus(302);

        $newKaraOta = \App\Models\KaraOta::find($id);
        $this->assertEquals($name, $newKaraOta->name);
    }

    public function testDeleteModel()
    {
        $karaOta = factory(\App\Models\KaraOta::class)->create();

        $id = $karaOta->id;

        $this->action('DELETE', 'Admin\AppOtaController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkKaraOta = \App\Models\KaraOta::find($id);
        $this->assertNull($checkKaraOta);
    }

}
