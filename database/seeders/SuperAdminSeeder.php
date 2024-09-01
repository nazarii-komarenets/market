<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory([
            'name' => 'Super Admin',
            'email' => 'komarenecn@gmail.com',
            'password' => Hash::make('_Nokian958gb'),
            'is_admin' => 1,
        ])->create();
    }
}
