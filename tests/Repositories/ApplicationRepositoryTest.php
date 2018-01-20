<?php namespace Tests\Repositories;

use App\Models\Application;
use Tests\TestCase;

class ApplicationRepositoryTest extends TestCase
{
    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);
    }

    public function testGetList()
    {
        $applications = factory(Application::class, 3)->create();
        $applicationIds = $applications->pluck('id')->toArray();

        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $applicationsCheck = $repository->get('id', 'asc', 0, 1);
        $this->assertInstanceOf(Application::class, $applicationsCheck[0]);

        $applicationsCheck = $repository->getByIds($applicationIds);
        $this->assertEquals(3, count($applicationsCheck));
    }

    public function testFind()
    {
        $applications = factory(Application::class, 3)->create();
        $applicationIds = $applications->pluck('id')->toArray();

        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $applicationCheck = $repository->find($applicationIds[0]);
        $this->assertEquals($applicationIds[0], $applicationCheck->id);
    }

    public function testCreate()
    {
        $applicationData = factory(Application::class)->make();

        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $applicationCheck = $repository->create($applicationData->toFillableArray());
        $this->assertNotNull($applicationCheck);
    }

    public function testUpdate()
    {
        $applicationData = factory(Application::class)->create();

        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $applicationCheck = $repository->update($applicationData, $applicationData->toFillableArray());
        $this->assertNotNull($applicationCheck);
    }

    public function testDelete()
    {
        $applicationData = factory(Application::class)->create();

        /** @var  \App\Repositories\ApplicationRepositoryInterface $repository */
        $repository = \App::make(\App\Repositories\ApplicationRepositoryInterface::class);
        $this->assertNotNull($repository);

        $repository->delete($applicationData);

        $applicationCheck = $repository->find($applicationData->id);
        $this->assertNull($applicationCheck);
    }

}
