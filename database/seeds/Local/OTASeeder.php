<?php

namespace Seeds\Local;

use App\Models\Application;
use App\Models\KaraOta;
use App\Models\KaraVersion;
use Illuminate\Database\Seeder;

class OTASeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 5, 1) as $numberApplications)
        {
            factory(Application::class)->create();
        }

        foreach (range(1, 60, 1) as $numberVersion)
        {
            factory(KaraVersion::class)->create(
                [
                    'application_id'  => rand(1, 5),
                ]
            );
        }

        foreach (range(1, 50, 1) as $numberOTA)
        {
            factory(KaraOta::class)->create(
                [
                    'os_version_id'   => rand(1, 20),
                    'sdk_version_id'  => rand(1, 20),
                    'box_version_id'  => rand(1, 50),
                    'kara_version_id' => rand(1, 50),
                    'application_id'  => rand(1, 5),
                ]
            );
        }
    }
}