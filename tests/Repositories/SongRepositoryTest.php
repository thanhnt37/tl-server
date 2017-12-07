<?php namespace Tests\Repositories;

use App\Models\Song;
use Tests\TestCase;

class SongRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $songs = factory(Song::class, 3)->create();
        $songIds = $songs->pluck('id')->toArray();

        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $songsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Song::class, $songsCheck[0]);

        $songsCheck = $repository->getByIds($songIds);
        $this->assertEquals(3, count($songsCheck));
    }

    public function testFind()
    {
        $songs = factory(Song::class, 3)->create();
        $songIds = $songs->pluck('id')->toArray();

        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $songCheck = $repository->find($songIds[0]);
        $this->assertEquals($songIds[0], $songCheck->id);
    }

    public function testCreate()
    {
        $songData = factory(Song::class)->make();

        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $songCheck = $repository->create($songData->toFillableArray());
        $this->assertNotNull($songCheck);
    }

    public function testUpdate()
    {
        $songData = factory(Song::class)->create();

        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $songCheck = $repository->update($songData, $songData->toFillableArray());
        $this->assertNotNull($songCheck);
    }

    public function testDelete()
    {
        $songData = factory(Song::class)->create();

        /** @var  \App\Repositories\SongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($songData);

        $songCheck = $repository->find($songData->id);
        $this->assertNull($songCheck);
    }

}
