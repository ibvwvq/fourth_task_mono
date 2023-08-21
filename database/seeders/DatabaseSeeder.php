<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Feedback;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        User::factory(10)->create();
//        Product::factory(10)->create();

        //Feedback::factory(10)->create();
        Rating::factory(10)->create();
    }
}
