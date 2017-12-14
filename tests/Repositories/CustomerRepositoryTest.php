<?php namespace Tests\Repositories;

use App\Models\Customer;
use Tests\TestCase;

class CustomerRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $customers = factory(Customer::class, 3)->create();
        $customerIds = $customers->pluck('id')->toArray();

        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Customer::class, $customersCheck[0]);

        $customersCheck = $repository->getByIds($customerIds);
        $this->assertEquals(3, count($customersCheck));
    }

    public function testFind()
    {
        $customers = factory(Customer::class, 3)->create();
        $customerIds = $customers->pluck('id')->toArray();

        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->find($customerIds[0]);
        $this->assertEquals($customerIds[0], $customerCheck->id);
    }

    public function testCreate()
    {
        $customerData = factory(Customer::class)->make();

        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->create($customerData->toFillableArray());
        $this->assertNotNull($customerCheck);
    }

    public function testUpdate()
    {
        $customerData = factory(Customer::class)->create();

        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $customerCheck = $repository->update($customerData, $customerData->toFillableArray());
        $this->assertNotNull($customerCheck);
    }

    public function testDelete()
    {
        $customerData = factory(Customer::class)->create();

        /** @var  \App\Repositories\CustomerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\CustomerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($customerData);

        $customerCheck = $repository->find($customerData->id);
        $this->assertNull($customerCheck);
    }

}
