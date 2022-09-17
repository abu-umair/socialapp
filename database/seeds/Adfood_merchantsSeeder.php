<?php

use Illuminate\Database\Seeder;

class Adfood_merchantsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('adfood_merchants')->insert([
            [
                'website' => 'one.com',
                'open-restaurant' => '13:41:00',
                'close-restaurant' => '16:41:00',
                'about' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'menus-restaurant' => null,
                'status' => 1,
            ],
            [
                'website' => 'two.com',
                'open-restaurant' => '07:00:00',
                'close-restaurant' => '16:00:00',
                'about' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
                'menus-restaurant' => null,
                'status' => 1,
            ],
            
        ]);
    }
}
