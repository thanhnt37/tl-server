<?php

namespace Seeds\Local;

use App\Models\Box;
use App\Models\BoxVersion;
use App\Models\OsVersion;
use App\Models\SdkVersion;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    public function run()
    {
        // box version
        foreach(range(1, 60, 1) as $numberBoxVersion) {
            factory(BoxVersion::class)->create();
        }

        // os version
        foreach(range(1, 20, 1) as $numberOsVersion) {
            factory(OsVersion::class)->create();
        }

        // sdk version
        foreach(range(1, 20, 1) as $numberSdkVersion) {
            factory(SdkVersion::class)->create();
        }

        foreach(range(50, 100) as $numberBox) {
            factory(Box::class)->create(
                [
                    'box_version_id' => rand(1, 20),
                    'os_version_id'  => rand(1, 20),
                    'sdk_version_id' => rand(1, 20),
                ]
            );
        }
    }
}
