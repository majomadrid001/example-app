<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsecaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('usecases')->insert(
            [
                ['name'=>'A', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name'=>'B', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
                ['name'=>'C', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ]
        );
    }
}
