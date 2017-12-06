<?php namespace Tests\Repositories;

use App\Models\OsVersion;
use Tests\TestCase;

class OsVersionRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $osVersions = factory(OsVersion::class, 3)->create();
        $osVersionIds = $osVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $osVersionsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(OsVersion::class, $osVersionsCheck[0]);

        $osVersionsCheck = $repository->getByIds($osVersionIds);
        $this->assertEquals(3, count($osVersionsCheck));
    }

    public function testFind()
    {
        $osVersions = factory(OsVersion::class, 3)->create();
        $osVersionIds = $osVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $osVersionCheck = $repository->find($osVersionIds[0]);
        $this->assertEquals($osVersionIds[0], $osVersionCheck->id);
    }

    public function testCreate()
    {
        $osVersionData = factory(OsVersion::class)->make();

        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $osVersionCheck = $repository->create($osVersionData->toFillableArray());
        $this->assertNotNull($osVersionCheck);
    }

    public function testUpdate()
    {
        $osVersionData = factory(OsVersion::class)->create();

        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $osVersionCheck = $repository->update($osVersionData, $osVersionData->toFillableArray());
        $this->assertNotNull($osVersionCheck);
    }

    public function testDelete()
    {
        $osVersionData = factory(OsVersion::class)->create();

        /** @var  \App\Repositories\OsVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\OsVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($osVersionData);

        $osVersionCheck = $repository->find($osVersionData->id);
        $this->assertNull($osVersionCheck);
    }

}
