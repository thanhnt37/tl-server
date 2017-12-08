<?php namespace Tests\Repositories;

use App\Models\Author;
use Tests\TestCase;

class AuthorRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $authors = factory(Author::class, 3)->create();
        $authorIds = $authors->pluck('id')->toArray();

        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);

        $authorsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Author::class, $authorsCheck[0]);

        $authorsCheck = $repository->getByIds($authorIds);
        $this->assertEquals(3, count($authorsCheck));
    }

    public function testFind()
    {
        $authors = factory(Author::class, 3)->create();
        $authorIds = $authors->pluck('id')->toArray();

        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);

        $authorCheck = $repository->find($authorIds[0]);
        $this->assertEquals($authorIds[0], $authorCheck->id);
    }

    public function testCreate()
    {
        $authorData = factory(Author::class)->make();

        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);

        $authorCheck = $repository->create($authorData->toFillableArray());
        $this->assertNotNull($authorCheck);
    }

    public function testUpdate()
    {
        $authorData = factory(Author::class)->create();

        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);

        $authorCheck = $repository->update($authorData, $authorData->toFillableArray());
        $this->assertNotNull($authorCheck);
    }

    public function testDelete()
    {
        $authorData = factory(Author::class)->create();

        /** @var  \App\Repositories\AuthorRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\AuthorRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($authorData);

        $authorCheck = $repository->find($authorData->id);
        $this->assertNull($authorCheck);
    }

}
