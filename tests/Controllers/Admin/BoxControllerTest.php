<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class BoxControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\BoxController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\BoxController::class);
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
        $response = $this->action('GET', 'Admin\BoxController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\BoxController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $box = factory(\App\Models\Box::class)->make();
        $this->action('POST', 'Admin\BoxController@store', [
                '_token' => csrf_token(),
            ] + $box->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $box = factory(\App\Models\Box::class)->create();
        $this->action('GET', 'Admin\BoxController@show', [$box->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $box = factory(\App\Models\Box::class)->create();

        $name = $faker->name;
        $id = $box->id;

        $box->name = $name;

        $this->action('PUT', 'Admin\BoxController@update', [$id], [
                '_token' => csrf_token(),
            ] + $box->toArray());
        $this->assertResponseStatus(302);

        $newBox = \App\Models\Box::find($id);
        $this->assertEquals($name, $newBox->name);
    }

    public function testDeleteModel()
    {
        $box = factory(\App\Models\Box::class)->create();

        $id = $box->id;

        $this->action('DELETE', 'Admin\BoxController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkBox = \App\Models\Box::find($id);
        $this->assertNull($checkBox);
    }

}
