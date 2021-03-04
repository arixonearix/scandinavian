<?php

namespace Database\Seeders;

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
        DB::table('page_config')->insert([
            'name' => Str::random(10),
            'data' => '{"rows":4, "cols":5, "thumbCount": 20}'
        ]);
    }
}
