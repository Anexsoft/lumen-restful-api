<?php

use ProductSeeder;
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
        $this->call(CustomerSeeder::class);
        $this->call(ProductSeeder::class);
    }
}