<?php

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
        DB::table('authors')->insert([
            'name' => 'LocutorCo',
            'slug' => Str::slug('LocutorCo'),
        ]);

        DB::table('authors')->insert([
            'name' => 'Joan Boluda',
            'slug' => Str::slug('Joan Boluda'),
        ]);

        DB::table('categories')->insert([
            'name' => 'Podcasting',
            'slug' => Str::slug('Podcasting'),
        ]);

        DB::table('categories')->insert([
            'name' => 'Marketing',
            'slug' => Str::slug('Marketing'),
        ]);

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
