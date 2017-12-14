<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class SaleControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\SaleController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\SaleController::class);
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
        $response = $this->action('GET', 'Admin\SaleController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\SaleController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $sale = factory(\App\Models\Sale::class)->make();
        $this->action('POST', 'Admin\SaleController@store', [
                '_token' => csrf_token(),
            ] + $sale->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $sale = factory(\App\Models\Sale::class)->create();
        $this->action('GET', 'Admin\SaleController@show', [$sale->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $sale = factory(\App\Models\Sale::class)->create();

        $name = $faker->name;
        $id = $sale->id;

        $sale->name = $name;

        $this->action('PUT', 'Admin\SaleController@update', [$id], [
                '_token' => csrf_token(),
            ] + $sale->toArray());
        $this->assertResponseStatus(302);

        $newSale = \App\Models\Sale::find($id);
        $this->assertEquals($name, $newSale->name);
    }

    public function testDeleteModel()
    {
        $sale = factory(\App\Models\Sale::class)->create();

        $id = $sale->id;

        $this->action('DELETE', 'Admin\SaleController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkSale = \App\Models\Sale::find($id);
        $this->assertNull($checkSale);
    }

}
