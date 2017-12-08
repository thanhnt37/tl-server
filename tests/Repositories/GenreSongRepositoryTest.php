<?php namespace Tests\Repositories;

use App\Models\GenreSong;
use Tests\TestCase;

class GenreSongRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $genreSongs = factory(GenreSong::class, 3)->create();
        $genreSongIds = $genreSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreSongsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(GenreSong::class, $genreSongsCheck[0]);

        $genreSongsCheck = $repository->getByIds($genreSongIds);
        $this->assertEquals(3, count($genreSongsCheck));
    }

    public function testFind()
    {
        $genreSongs = factory(GenreSong::class, 3)->create();
        $genreSongIds = $genreSongs->pluck('id')->toArray();

        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreSongCheck = $repository->find($genreSongIds[0]);
        $this->assertEquals($genreSongIds[0], $genreSongCheck->id);
    }

    public function testCreate()
    {
        $genreSongData = factory(GenreSong::class)->make();

        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreSongCheck = $repository->create($genreSongData->toFillableArray());
        $this->assertNotNull($genreSongCheck);
    }

    public function testUpdate()
    {
        $genreSongData = factory(GenreSong::class)->create();

        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreSongCheck = $repository->update($genreSongData, $genreSongData->toFillableArray());
        $this->assertNotNull($genreSongCheck);
    }

    public function testDelete()
    {
        $genreSongData = factory(GenreSong::class)->create();

        /** @var  \App\Repositories\GenreSongRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreSongRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($genreSongData);

        $genreSongCheck = $repository->find($genreSongData->id);
        $this->assertNull($genreSongCheck);
    }

}
