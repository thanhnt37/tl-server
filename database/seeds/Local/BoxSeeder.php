<?php

namespace Seeds\Local;

use App\Models\Box;
use Illuminate\Database\Seeder;

class BoxSeeder extends Seeder
{
    public function run()
    {
        foreach(range(50, 100) as $numberBox) {
            factory(Box::class)->create();
        }
    }
}
