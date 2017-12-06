<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class SdkVersionControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\SdkVersionController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\SdkVersionController::class);
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
        $response = $this->action('GET', 'Admin\SdkVersionController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\SdkVersionController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $sdkVersion = factory(\App\Models\SdkVersion::class)->make();
        $this->action('POST', 'Admin\SdkVersionController@store', [
                '_token' => csrf_token(),
            ] + $sdkVersion->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $sdkVersion = factory(\App\Models\SdkVersion::class)->create();
        $this->action('GET', 'Admin\SdkVersionController@show', [$sdkVersion->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $sdkVersion = factory(\App\Models\SdkVersion::class)->create();

        $name = $faker->name;
        $id = $sdkVersion->id;

        $sdkVersion->name = $name;

        $this->action('PUT', 'Admin\SdkVersionController@update', [$id], [
                '_token' => csrf_token(),
            ] + $sdkVersion->toArray());
        $this->assertResponseStatus(302);

        $newSdkVersion = \App\Models\SdkVersion::find($id);
        $this->assertEquals($name, $newSdkVersion->name);
    }

    public function testDeleteModel()
    {
        $sdkVersion = factory(\App\Models\SdkVersion::class)->create();

        $id = $sdkVersion->id;

        $this->action('DELETE', 'Admin\SdkVersionController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkSdkVersion = \App\Models\SdkVersion::find($id);
        $this->assertNull($checkSdkVersion);
    }

}
