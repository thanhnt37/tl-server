<?php namespace Tests\Repositories;

use App\Models\Box;
use Tests\TestCase;

class BoxRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $boxes = factory(Box::class, 3)->create();
        $boxIds = $boxes->pluck('id')->toArray();

        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxesCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Box::class, $boxesCheck[0]);

        $boxesCheck = $repository->getByIds($boxIds);
        $this->assertEquals(3, count($boxesCheck));
    }

    public function testFind()
    {
        $boxes = factory(Box::class, 3)->create();
        $boxIds = $boxes->pluck('id')->toArray();

        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxCheck = $repository->find($boxIds[0]);
        $this->assertEquals($boxIds[0], $boxCheck->id);
    }

    public function testCreate()
    {
        $boxData = factory(Box::class)->make();

        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxCheck = $repository->create($boxData->toFillableArray());
        $this->assertNotNull($boxCheck);
    }

    public function testUpdate()
    {
        $boxData = factory(Box::class)->create();

        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxCheck = $repository->update($boxData, $boxData->toFillableArray());
        $this->assertNotNull($boxCheck);
    }

    public function testDelete()
    {
        $boxData = factory(Box::class)->create();

        /** @var  \App\Repositories\BoxRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($boxData);

        $boxCheck = $repository->find($boxData->id);
        $this->assertNull($boxCheck);
    }

}
