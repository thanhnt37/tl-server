<?php namespace Tests\Repositories;

use App\Models\AlbumSong;
use Tests\TestCase;

class AlbumSongRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $albumSongs = factory(AlbumSong::class, 3)->create();
        $albumSongIds = $albumSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumSongsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(AlbumSong::class, $albumSongsCheck[0]);

        $albumSongsCheck = $repository->getByIds($albumSongIds);
        $this->assertEquals(3, count($albumSongsCheck));
    }

    public function testFind()
    {
        $albumSongs = factory(AlbumSong::class, 3)->create();
        $albumSongIds = $albumSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumSongCheck = $repository->find($albumSongIds[0]);
        $this->assertEquals($albumSongIds[0], $albumSongCheck->id);
    }

    public function testCreate()
    {
        $albumSongData = factory(AlbumSong::class)->make();

        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumSongCheck = $repository->create($albumSongData->toFillableArray());
        $this->assertNotNull($albumSongCheck);
    }

    public function testUpdate()
    {
        $albumSongData = factory(AlbumSong::class)->create();

        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $albumSongCheck = $repository->update($albumSongData, $albumSongData->toFillableArray());
        $this->assertNotNull($albumSongCheck);
    }

    public function testDelete()
    {
        $albumSongData = factory(AlbumSong::class)->create();

        /** @var  \App\Repositories\AlbumSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AlbumSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($albumSongData);

        $albumSongCheck = $repository->find($albumSongData->id);
        $this->assertNull($albumSongCheck);
    }

}
