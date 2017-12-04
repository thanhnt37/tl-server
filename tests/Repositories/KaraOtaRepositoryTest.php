<?php namespace Tests\Repositories;

use App\Models\KaraOta;
use Tests\TestCase;

class KaraOtaRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $karaOta = factory(KaraOta::class, 3)->create();
        $karaOtaIds = $karaOta->pluck('id')->toArray();

        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaOtaCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(KaraOta::class, $karaOtaCheck[0]);

        $karaOtaCheck = $repository->getByIds($karaOtaIds);
        $this->assertEquals(3, count($karaOtaCheck));
    }

    public function testFind()
    {
        $karaOta = factory(KaraOta::class, 3)->create();
        $karaOtaIds = $karaOta->pluck('id')->toArray();

        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaOtaCheck = $repository->find($karaOtaIds[0]);
        $this->assertEquals($karaOtaIds[0], $karaOtaCheck->id);
    }

    public function testCreate()
    {
        $karaOtaData = factory(KaraOta::class)->make();

        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaOtaCheck = $repository->create($karaOtaData->toFillableArray());
        $this->assertNotNull($karaOtaCheck);
    }

    public function testUpdate()
    {
        $karaOtaData = factory(KaraOta::class)->create();

        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);

        $karaOtaCheck = $repository->update($karaOtaData, $karaOtaData->toFillableArray());
        $this->assertNotNull($karaOtaCheck);
    }

    public function testDelete()
    {
        $karaOtaData = factory(KaraOta::class)->create();

        /** @var  \App\Repositories\KaraOtaRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\KaraOtaRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($karaOtaData);

        $karaOtaCheck = $repository->find($karaOtaData->id);
        $this->assertNull($karaOtaCheck);
    }

}
