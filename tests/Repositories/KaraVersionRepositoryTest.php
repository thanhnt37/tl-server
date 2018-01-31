<?php namespace Tests\Repositories;

use App\Models\AppVersion;
use Tests\TestCase;

class KaraVersionRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $karaVersions = factory(AppVersion::class, 3)->create();
        $karaVersionIds = $karaVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaVersionsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(AppVersion::class, $karaVersionsCheck[0]);

        $karaVersionsCheck = $repository->getByIds($karaVersionIds);
        $this->assertEquals(3, count($karaVersionsCheck));
    }

    public function testFind()
    {
        $karaVersions = factory(AppVersion::class, 3)->create();
        $karaVersionIds = $karaVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaVersionCheck = $repository->find($karaVersionIds[0]);
        $this->assertEquals($karaVersionIds[0], $karaVersionCheck->id);
    }

    public function testCreate()
    {
        $karaVersionData = factory(AppVersion::class)->make();

        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaVersionCheck = $repository->create($karaVersionData->toFillableArray());
        $this->assertNotNull($karaVersionCheck);
    }

    public function testUpdate()
    {
        $karaVersionData = factory(AppVersion::class)->create();

        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaVersionCheck = $repository->update($karaVersionData, $karaVersionData->toFillableArray());
        $this->assertNotNull($karaVersionCheck);
    }

    public function testDelete()
    {
        $karaVersionData = factory(AppVersion::class)->create();

        /** @var  \App\Repositories\KaraVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($karaVersionData);

        $karaVersionCheck = $repository->find($karaVersionData->id);
        $this->assertNull($karaVersionCheck);
    }

}
