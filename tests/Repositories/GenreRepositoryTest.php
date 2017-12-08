<?php namespace Tests\Repositories;

use App\Models\Genre;
use Tests\TestCase;

class GenreRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $genres = factory(Genre::class, 3)->create();
        $genreIds = $genres->pluck('id')->toArray();

        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genresCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Genre::class, $genresCheck[0]);

        $genresCheck = $repository->getByIds($genreIds);
        $this->assertEquals(3, count($genresCheck));
    }

    public function testFind()
    {
        $genres = factory(Genre::class, 3)->create();
        $genreIds = $genres->pluck('id')->toArray();

        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreCheck = $repository->find($genreIds[0]);
        $this->assertEquals($genreIds[0], $genreCheck->id);
    }

    public function testCreate()
    {
        $genreData = factory(Genre::class)->make();

        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreCheck = $repository->create($genreData->toFillableArray());
        $this->assertNotNull($genreCheck);
    }

    public function testUpdate()
    {
        $genreData = factory(Genre::class)->create();

        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);

        $genreCheck = $repository->update($genreData, $genreData->toFillableArray());
        $this->assertNotNull($genreCheck);
    }

    public function testDelete()
    {
        $genreData = factory(Genre::class)->create();

        /** @var  \App\Repositories\GenreRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\GenreRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($genreData);

        $genreCheck = $repository->find($genreData->id);
        $this->assertNull($genreCheck);
    }

}
