<?php  namespace Tests\Controllers\Admin;

use Tests\TestCase;

class CustomerControllerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Http\Controllers\Admin\CustomerController $controller */
        $controller = \App::make(\App\Http\Controllers\Admin\CustomerController::class);
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
        $response = $this->action('GET', 'Admin\CustomerController@index');
        $this->assertResponseOk();
    }

    public function testCreateModel()
    {
        $this->action('GET', 'Admin\CustomerController@create');
        $this->assertResponseOk();
    }

    public function testStoreModel()
    {
        $customer = factory(\App\Models\Customer::class)->make();
        $this->action('POST', 'Admin\CustomerController@store', [
                '_token' => csrf_token(),
            ] + $customer->toArray());
        $this->assertResponseStatus(302);
    }

    public function testEditModel()
    {
        $customer = factory(\App\Models\Customer::class)->create();
        $this->action('GET', 'Admin\CustomerController@show', [$customer->id]);
        $this->assertResponseOk();
    }

    public function testUpdateModel()
    {
        $faker = \Faker\Factory::create();

        $customer = factory(\App\Models\Customer::class)->create();

        $name = $faker->name;
        $id = $customer->id;

        $customer->name = $name;

        $this->action('PUT', 'Admin\CustomerController@update', [$id], [
                '_token' => csrf_token(),
            ] + $customer->toArray());
        $this->assertResponseStatus(302);

        $newCustomer = \App\Models\Customer::find($id);
        $this->assertEquals($name, $newCustomer->name);
    }

    public function testDeleteModel()
    {
        $customer = factory(\App\Models\Customer::class)->create();

        $id = $customer->id;

        $this->action('DELETE', 'Admin\CustomerController@destroy', [$id], [
                '_token' => csrf_token(),
            ]);
        $this->assertResponseStatus(302);

        $checkCustomer = \App\Models\Customer::find($id);
        $this->assertNull($checkCustomer);
    }

}
