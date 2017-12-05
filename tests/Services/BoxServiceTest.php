<?php namespace Tests\Services;

use Tests\TestCase;

class BoxServiceTest extends TestCase
{

    public function testGetInstance()
    {
        /** @var  \App\Services\BoxServiceInterface $service */
        $service = \App::make(\App\Services\BoxServiceInterface::class);
        $this->assertNotNull($service);
    }

}
