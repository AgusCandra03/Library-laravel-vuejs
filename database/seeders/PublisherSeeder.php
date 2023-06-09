<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Publisher;

class PublisherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0; $i <10; $i++){
            $publisher = new Publisher;

            $publisher->name = $faker->company();
            $publisher->email = $faker->email();
            $publisher->phone_number = '0711'.$faker->randomNumber(6);
            $publisher->address = $faker->address();

            $publisher->save();
        }
    }
}
