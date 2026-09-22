<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolesAndPermissionsSeeder::class);
        $this->call(PaymentMethodSeeder::class);

        $admin = User::factory()->create([
            'name' => 'Houdini Omwakwe',
            'email' => 'derricreuben@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $admin->assignRole('Super Admin');

        $this->call(DemoContentSeeder::class);
    }
}
