<?php

use App\Catagory;
use Illuminate\Database\Seeder;

class CatagorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
        factory(Catagory::class,10)->create();
    }
}
