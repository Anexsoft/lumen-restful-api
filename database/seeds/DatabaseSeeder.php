<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleSeeder::class);        

        if(App::environment('local')) 
        {
            $this->call(CustomerSeeder::class);
            $this->call(ProductSeeder::class);
            $this->call(UserSeeder::class);
        }
    }
}
