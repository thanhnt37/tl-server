<?php namespace Tests\Repositories;

use App\Models\SdkVersion;
use Tests\TestCase;

class SdkVersionRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $sdkVersions = factory(SdkVersion::class, 3)->create();
        $sdkVersionIds = $sdkVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $sdkVersionsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(SdkVersion::class, $sdkVersionsCheck[0]);

        $sdkVersionsCheck = $repository->getByIds($sdkVersionIds);
        $this->assertEquals(3, count($sdkVersionsCheck));
    }

    public function testFind()
    {
        $sdkVersions = factory(SdkVersion::class, 3)->create();
        $sdkVersionIds = $sdkVersions->pluck('id')->toArray();

        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $sdkVersionCheck = $repository->find($sdkVersionIds[0]);
        $this->assertEquals($sdkVersionIds[0], $sdkVersionCheck->id);
    }

    public function testCreate()
    {
        $sdkVersionData = factory(SdkVersion::class)->make();

        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $sdkVersionCheck = $repository->create($sdkVersionData->toFillableArray());
        $this->assertNotNull($sdkVersionCheck);
    }

    public function testUpdate()
    {
        $sdkVersionData = factory(SdkVersion::class)->create();

        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $sdkVersionCheck = $repository->update($sdkVersionData, $sdkVersionData->toFillableArray());
        $this->assertNotNull($sdkVersionCheck);
    }

    public function testDelete()
    {
        $sdkVersionData = factory(SdkVersion::class)->create();

        /** @var  \App\Repositories\SdkVersionRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SdkVersionRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($sdkVersionData);

        $sdkVersionCheck = $repository->find($sdkVersionData->id);
        $this->assertNull($sdkVersionCheck);
    }

}
