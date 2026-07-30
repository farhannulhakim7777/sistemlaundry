<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminSeeder extends Seeder
{
    public function run()
    {
        Admin::updateOrCreate(
            ['username' => 'admin'],
            ['name' => 'Administrator', 'password' => 'admin123']
        );
    }
}
