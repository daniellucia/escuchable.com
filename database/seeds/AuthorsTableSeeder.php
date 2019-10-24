<?php

use Illuminate\Database\Seeder;

class AuthorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
    }
}
