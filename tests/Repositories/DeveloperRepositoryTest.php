<?php namespace Tests\Repositories;

use App\Models\Developer;
use Tests\TestCase;

class DeveloperRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $developers = factory(Developer::class, 3)->create();
        $developerIds = $developers->pluck('id')->toArray();

        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);

        $developersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Developer::class, $developersCheck[0]);

        $developersCheck = $repository->getByIds($developerIds);
        $this->assertEquals(3, count($developersCheck));
    }

    public function testFind()
    {
        $developers = factory(Developer::class, 3)->create();
        $developerIds = $developers->pluck('id')->toArray();

        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);

        $developerCheck = $repository->find($developerIds[0]);
        $this->assertEquals($developerIds[0], $developerCheck->id);
    }

    public function testCreate()
    {
        $developerData = factory(Developer::class)->make();

        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);

        $developerCheck = $repository->create($developerData->toFillableArray());
        $this->assertNotNull($developerCheck);
    }

    public function testUpdate()
    {
        $developerData = factory(Developer::class)->create();

        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);

        $developerCheck = $repository->update($developerData, $developerData->toFillableArray());
        $this->assertNotNull($developerCheck);
    }

    public function testDelete()
    {
        $developerData = factory(Developer::class)->create();

        /** @var  \App\Repositories\DeveloperRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\DeveloperRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($developerData);

        $developerCheck = $repository->find($developerData->id);
        $this->assertNull($developerCheck);
    }

}
