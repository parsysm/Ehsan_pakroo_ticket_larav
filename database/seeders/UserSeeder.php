<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //First Support/Customer user
        User::insert([
            [
                'uuid' => generateUuid4(),
                'name' => 'Ehsan Pakroo',
                'email' => 'etherneticals@gmail.com',
                'password' => bcrypt('123456'),
                'is_customer' => false,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'uuid' => generateUuid4(),
                'name' => 'Ehsan Pak',
                'email' => 'pakroo.ehsan@yahoo.com',
                'password' => bcrypt('123456'),
                'is_customer' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
