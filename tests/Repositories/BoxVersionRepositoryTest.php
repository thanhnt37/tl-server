<?php namespace Tests\Repositories;

use App\Models\BoxVersion;
use Tests\TestCase;

class BoxVersionRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $boxVersions = factory(BoxVersion::class, 3)->create();
        $boxVersionIds = $boxVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxVersionsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(BoxVersion::class, $boxVersionsCheck[0]);

        $boxVersionsCheck = $repository->getByIds($boxVersionIds);
        $this->assertEquals(3, count($boxVersionsCheck));
    }

    public function testFind()
    {
        $boxVersions = factory(BoxVersion::class, 3)->create();
        $boxVersionIds = $boxVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxVersionCheck = $repository->find($boxVersionIds[0]);
        $this->assertEquals($boxVersionIds[0], $boxVersionCheck->id);
    }

    public function testCreate()
    {
        $boxVersionData = factory(BoxVersion::class)->make();

        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxVersionCheck = $repository->create($boxVersionData->toFillableArray());
        $this->assertNotNull($boxVersionCheck);
    }

    public function testUpdate()
    {
        $boxVersionData = factory(BoxVersion::class)->create();

        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $boxVersionCheck = $repository->update($boxVersionData, $boxVersionData->toFillableArray());
        $this->assertNotNull($boxVersionCheck);
    }

    public function testDelete()
    {
        $boxVersionData = factory(BoxVersion::class)->create();

        /** @var  \App\Repositories\BoxVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\BoxVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($boxVersionData);

        $boxVersionCheck = $repository->find($boxVersionData->id);
        $this->assertNull($boxVersionCheck);
    }

}
