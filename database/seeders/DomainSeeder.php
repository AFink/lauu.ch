<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('domains')->insert(
            [
                [
                    'name' => 'http://localhost:8000',
                    'user_id' => 1,
                    'public' => false
                ],
                [
                    'name' => 'https://beta2.08z.de/',
                    'user_id' => 1,
                    'public' => true
                ],
                [
                    'name' => 'https://beta.07z.de/',
                    'user_id' => 1,
                    'public' => true
                ]
            ]
        );
    }
}