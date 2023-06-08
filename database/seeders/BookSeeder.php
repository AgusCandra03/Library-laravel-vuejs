<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Book;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for($i=0; $i < 18; $i++){
            $book = new Book;

            $book->isbn = $faker->randomNumber(9);
            $book->title = $faker->jobTitle();
            $book->year = rand(2015, 2022);
            $book->publisher_id = rand(1, 10);
            $book->author_id = rand(1, 20);
            $book->catalog_id = rand(1, 4);
            $book->qty = $faker->randomNumber(2);
            $book->price = $faker->randomNumber(2).'0000';

            $book->save();
        }
    }
}
