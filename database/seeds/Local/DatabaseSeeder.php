<?php

namespace Seeds\Local;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(BoxSeeder::class);
         $this->call(OTASeeder::class);
         $this->call(AlbumSeeder::class);
         $this->call(CustomerSeeder::class);
         $this->call(TLStoreSeeder::class);
    }
}
