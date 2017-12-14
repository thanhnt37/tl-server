<?php

namespace Seeds\Local;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        foreach(range(1, 30, 1) as $numberCustomer) {
            factory(Customer::class)->create();
        }
    }
}
