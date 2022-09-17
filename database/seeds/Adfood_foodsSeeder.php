<?php

use Illuminate\Database\Seeder;

class Adfood_foodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adfood_food')->insert([
            [
                'name' => 'Mayones',
                'category' => 'Food europa',
                'price' => 30000,
                'promo' => null,
                'status' => 1,
            ],
            [
                'name' => 'Ikan Goreng',
                'category' => 'Food Chinese',
                'price' => 50000,
                'promo' => null,
                'status' => 1,
            ],
            [
                'name' => 'Cumi Mentah',
                'category' => 'Food Japanse',
                'price' => 40000,
                'promo' => 20,
                'status' => 1,
            ],
        ]);
    }
}
