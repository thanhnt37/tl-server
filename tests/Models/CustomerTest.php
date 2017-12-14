<?php namespace Tests\Models;

use App\Models\Customer;
use Tests\TestCase;

class CustomerTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Customer $customer */
        $customer = new Customer();
        $this->assertNotNull($customer);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Customer $customer */
        $customerModel = new Customer();

        $customerData = factory(Customer::class)->make();
        foreach( $customerData->toFillableArray() as $key => $value ) {
            $customerModel->$key = $value;
        }
        $customerModel->save();

        $this->assertNotNull(Customer::find($customerModel->id));
    }

}
