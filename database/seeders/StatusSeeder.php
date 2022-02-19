<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Default statuses
        Status::insert([
            ['title' => 'Not Answered','is_public' => true],
            ['title' => 'In Progress','is_public' => true],
            ['title' => 'Answered','is_public' => true],
            ['title' => 'Spam', 'is_public' => false]
        ]);
    }
}
