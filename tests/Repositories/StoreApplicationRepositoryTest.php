<?php namespace Tests\Repositories;

use App\Models\StoreApplication;
use Tests\TestCase;

class StoreApplicationRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $storeApplications = factory(StoreApplication::class, 3)->create();
        $storeApplicationIds = $storeApplications->pluck('id')->toArray();

        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $storeApplicationsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(StoreApplication::class, $storeApplicationsCheck[0]);

        $storeApplicationsCheck = $repository->getByIds($storeApplicationIds);
        $this->assertEquals(3, count($storeApplicationsCheck));
    }

    public function testFind()
    {
        $storeApplications = factory(StoreApplication::class, 3)->create();
        $storeApplicationIds = $storeApplications->pluck('id')->toArray();

        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $storeApplicationCheck = $repository->find($storeApplicationIds[0]);
        $this->assertEquals($storeApplicationIds[0], $storeApplicationCheck->id);
    }

    public function testCreate()
    {
        $storeApplicationData = factory(StoreApplication::class)->make();

        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $storeApplicationCheck = $repository->create($storeApplicationData->toFillableArray());
        $this->assertNotNull($storeApplicationCheck);
    }

    public function testUpdate()
    {
        $storeApplicationData = factory(StoreApplication::class)->create();

        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $storeApplicationCheck = $repository->update($storeApplicationData, $storeApplicationData->toFillableArray());
        $this->assertNotNull($storeApplicationCheck);
    }

    public function testDelete()
    {
        $storeApplicationData = factory(StoreApplication::class)->create();

        /** @var  \App\Repositories\StoreApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\StoreApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($storeApplicationData);

        $storeApplicationCheck = $repository->find($storeApplicationData->id);
        $this->assertNull($storeApplicationCheck);
    }

}
