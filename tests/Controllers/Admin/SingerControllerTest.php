<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class SingerControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\SingerController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\SingerController::class);
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
        $response = $this->action('GET', 'Admin\SingerController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\SingerController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $singer = factory(\App\Models\Singer::class)->make();
        $this->action('POST', 'Admin\SingerController@store', [
                '_token' => csrf_token(),
            ] + $singer->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $singer = factory(\App\Models\Singer::class)->create();
        $this->action('GET', 'Admin\SingerController@show', [$singer->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $singer = factory(\App\Models\Singer::class)->create();

        $name = $faker->name;
        $id = $singer->id;

        $singer->name = $name;

        $this->action('PUT', 'Admin\SingerController@update', [$id], [
                '_token' => csrf_token(),
            ] + $singer->toArray());
        $this->assertResponseStatus(302);

        $newSinger = \App\Models\Singer::find($id);
        $this->assertEquals($name, $newSinger->name);
    }

    public function testDeleteModel()
    {
        $singer = factory(\App\Models\Singer::class)->create();

        $id = $singer->id;

        $this->action('DELETE', 'Admin\SingerController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkSinger = \App\Models\Singer::find($id);
        $this->assertNull($checkSinger);
    }

}
