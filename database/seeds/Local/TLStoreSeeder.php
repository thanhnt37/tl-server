<?php

namespace Seeds\Local;

use App\Models\Category;
use App\Models\Developer;
use App\Models\StoreApplication;
use Illuminate\Database\Seeder;

class TLStoreSeeder extends Seeder
{
    public function run()
    {
        foreach (range(1, 5, 1) as $numberCategories) {
            factory(Category::class)->create();
        }

        foreach (range(1, 10, 1) as $numberDevelopers) {
            factory(Developer::class)->create();
        }

        foreach (range(1, 5, 1) as $numberApplications) {
            factory(StoreApplication::class)->create(
                [
                    'category_id'  => rand(1, 5),
                    'developer_id' => rand(1, 10)
                ]
            );
        }
    }
}