<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class KaraVersionControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\KaraVersionController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\KaraVersionController::class);
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
        $response = $this->action('GET', 'Admin\KaraVersionController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\KaraVersionController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $karaVersion = factory(\App\Models\KaraVersion::class)->make();
        $this->action('POST', 'Admin\KaraVersionController@store', [
                '_token' => csrf_token(),
            ] + $karaVersion->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $karaVersion = factory(\App\Models\KaraVersion::class)->create();
        $this->action('GET', 'Admin\KaraVersionController@show', [$karaVersion->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $karaVersion = factory(\App\Models\KaraVersion::class)->create();

        $name = $faker->name;
        $id = $karaVersion->id;

        $karaVersion->name = $name;

        $this->action('PUT', 'Admin\KaraVersionController@update', [$id], [
                '_token' => csrf_token(),
            ] + $karaVersion->toArray());
        $this->assertResponseStatus(302);

        $newKaraVersion = \App\Models\KaraVersion::find($id);
        $this->assertEquals($name, $newKaraVersion->name);
    }

    public function testDeleteModel()
    {
        $karaVersion = factory(\App\Models\KaraVersion::class)->create();

        $id = $karaVersion->id;

        $this->action('DELETE', 'Admin\KaraVersionController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkKaraVersion = \App\Models\KaraVersion::find($id);
        $this->assertNull($checkKaraVersion);
    }

}
