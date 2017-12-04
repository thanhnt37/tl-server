<?php

namespace Seeds\Local;

use App\Models\KaraOta;
use App\Models\KaraVersion;
use Illuminate\Database\Seeder;

class OTASeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 60, 1) as $numberVersion) {
            factory(KaraVersion::class)->create();
        }

        foreach(range(1, 50, 1) as $numberOTA) {
            factory(KaraOta::class)->create(
                [
                    'kara_version_id' => rand(1, 50),
                ]
            );
        }
    }
}