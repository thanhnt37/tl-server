<?php namespace Tests\Models;

use App\Models\Application;
use Tests\TestCase;

class ApplicationTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Application $application */
        $application = new Application();
        $this->assertNotNull($application);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Application $application */
        $applicationModel = new Application();

        $applicationData = factory(Application::class)->make();
        foreach( $applicationData->toFillableArray() as $key => $value ) {
            $applicationModel->$key = $value;
        }
        $applicationModel->save();

        $this->assertNotNull(Application::find($applicationModel->id));
    }

}
