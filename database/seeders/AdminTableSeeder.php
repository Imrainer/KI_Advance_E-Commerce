<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create([
            'name' => 'Gazer',
            'email' => 'gazer@gmail.com',
            'phone' => '081932758058',
            'password' =>Hash::make('123456'),
        ]);
    }
}
