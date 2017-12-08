<?php namespace Tests\Repositories;

use App\Models\SingerSong;
use Tests\TestCase;

class SingerSongRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $singerSongs = factory(SingerSong::class, 3)->create();
        $singerSongIds = $singerSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerSongsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(SingerSong::class, $singerSongsCheck[0]);

        $singerSongsCheck = $repository->getByIds($singerSongIds);
        $this->assertEquals(3, count($singerSongsCheck));
    }

    public function testFind()
    {
        $singerSongs = factory(SingerSong::class, 3)->create();
        $singerSongIds = $singerSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerSongCheck = $repository->find($singerSongIds[0]);
        $this->assertEquals($singerSongIds[0], $singerSongCheck->id);
    }

    public function testCreate()
    {
        $singerSongData = factory(SingerSong::class)->make();

        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerSongCheck = $repository->create($singerSongData->toFillableArray());
        $this->assertNotNull($singerSongCheck);
    }

    public function testUpdate()
    {
        $singerSongData = factory(SingerSong::class)->create();

        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $singerSongCheck = $repository->update($singerSongData, $singerSongData->toFillableArray());
        $this->assertNotNull($singerSongCheck);
    }

    public function testDelete()
    {
        $singerSongData = factory(SingerSong::class)->create();

        /** @var  \App\Repositories\SingerSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\SingerSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($singerSongData);

        $singerSongCheck = $repository->find($singerSongData->id);
        $this->assertNull($singerSongCheck);
    }

}
