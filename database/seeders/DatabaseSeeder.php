<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SuperAdminSeeder::class,
            UserSeeder::class,
        ]);

        // Products
        $this->call([
            GameSeeder::class,
            ProductTypeSeeder::class,
            ProductSeeder::class,
        ]);

        // Orders
        $this->call([
            OrderStatusSeeder::class,
        ]);
    }
}
