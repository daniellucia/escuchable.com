<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ShowsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shows')->insert([
            'name' => 'El Siglo 21 es Hoy',
            'slug' => Str::slug('El Siglo 21 es Hoy'),
            'feed' => 'https://www.spreaker.com/show/880846/episodes/feed',
            'category' => 1,
            'author' => 1,
        ]);

        DB::table('shows')->insert([
            'name' => 'Marketing Online',
            'slug' => Str::slug('Marketing Online'),
            'feed' => 'https://boluda.com/podcast/feed/podcast/',
            'category' => 2,
            'author' => 2,
        ]);
    }
}
