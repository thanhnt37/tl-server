<?php namespace Tests\Models;

use App\Models\Topic;
use Tests\TestCase;

class TopicTest extends TestCase
{

    protected $useDatabase = true;

    public function testGetInstance()
    {
        /** @var  \App\Models\Topic $topic */
        $topic = new Topic();
        $this->assertNotNull($topic);
    }

    public function testStoreNew()
    {
        /** @var  \App\Models\Topic $topic */
        $topicModel = new Topic();

        $topicData = factory(Topic::class)->make();
        foreach( $topicData->toFillableArray() as $key => $value ) {
            $topicModel->$key = $value;
        }
        $topicModel->save();

        $this->assertNotNull(Topic::find($topicModel->id));
    }

}
