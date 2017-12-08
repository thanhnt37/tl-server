<?php namespace Tests\Repositories;

use App\Models\Singer;
use Tests\TestCase;

class SingerRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $singers = factory(Singer::class, 3)->create();
        $singerIds = $singers->pluck('id')->toArray();

        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singersCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Singer::class, $singersCheck[0]);

        $singersCheck = $repository->getByIds($singerIds);
        $this->assertEquals(3, count($singersCheck));
    }

    public function testFind()
    {
        $singers = factory(Singer::class, 3)->create();
        $singerIds = $singers->pluck('id')->toArray();

        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerCheck = $repository->find($singerIds[0]);
        $this->assertEquals($singerIds[0], $singerCheck->id);
    }

    public function testCreate()
    {
        $singerData = factory(Singer::class)->make();

        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerCheck = $repository->create($singerData->toFillableArray());
        $this->assertNotNull($singerCheck);
    }

    public function testUpdate()
    {
        $singerData = factory(Singer::class)->create();

        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerCheck = $repository->update($singerData, $singerData->toFillableArray());
        $this->assertNotNull($singerCheck);
    }

    public function testDelete()
    {
        $singerData = factory(Singer::class)->create();

        /** @var  \App\Repositories\SingerRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($singerData);

        $singerCheck = $repository->find($singerData->id);
        $this->assertNull($singerCheck);
    }

}
