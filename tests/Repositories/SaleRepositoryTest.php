<?php namespace Tests\Repositories;

use App\Models\Sale;
use Tests\TestCase;

class SaleRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $sales = factory(Sale::class, 3)->create();
        $saleIds = $sales->pluck('id')->toArray();

        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);

        $salesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Sale::class, $salesCheck[0]);

        $salesCheck = $repository->getByIds($saleIds);
        $this->assertEquals(3, count($salesCheck));
    }

    public function testFind()
    {
        $sales = factory(Sale::class, 3)->create();
        $saleIds = $sales->pluck('id')->toArray();

        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);

        $saleCheck = $repository->find($saleIds[0]);
        $this->assertEquals($saleIds[0], $saleCheck->id);
    }

    public function testCreate()
    {
        $saleData = factory(Sale::class)->make();

        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);

        $saleCheck = $repository->create($saleData->toFillableArray());
        $this->assertNotNull($saleCheck);
    }

    public function testUpdate()
    {
        $saleData = factory(Sale::class)->create();

        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);

        $saleCheck = $repository->update($saleData, $saleData->toFillableArray());
        $this->assertNotNull($saleCheck);
    }

    public function testDelete()
    {
        $saleData = factory(Sale::class)->create();

        /** @var  \App\Repositories\SaleRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SaleRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($saleData);

        $saleCheck = $repository->find($saleData->id);
        $this->assertNull($saleCheck);
    }

}
