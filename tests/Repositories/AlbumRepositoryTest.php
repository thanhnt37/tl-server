<?php namespace Tests\Repositories;

use App\Models\Album;
use Tests\TestCase;

class AlbumRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $albums = factory(Album::class, 3)->create();
        $albumIds = $albums->pluck('id')->toArray();

        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Album::class, $albumsCheck[0]);

        $albumsCheck = $repository->getByIds($albumIds);
        $this->assertEquals(3, count($albumsCheck));
    }

    public function testFind()
    {
        $albums = factory(Album::class, 3)->create();
        $albumIds = $albums->pluck('id')->toArray();

        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumCheck = $repository->find($albumIds[0]);
        $this->assertEquals($albumIds[0], $albumCheck->id);
    }

    public function testCreate()
    {
        $albumData = factory(Album::class)->make();

        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumCheck = $repository->create($albumData->toFillableArray());
        $this->assertNotNull($albumCheck);
    }

    public function testUpdate()
    {
        $albumData = factory(Album::class)->create();

        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumCheck = $repository->update($albumData, $albumData->toFillableArray());
        $this->assertNotNull($albumCheck);
    }

    public function testDelete()
    {
        $albumData = factory(Album::class)->create();

        /** @var  \App\Repositories\AlbumRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($albumData);

        $albumCheck = $repository->find($albumData->id);
        $this->assertNull($albumCheck);
    }

}
