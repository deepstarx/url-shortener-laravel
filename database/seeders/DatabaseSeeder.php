<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Enums\UserRole;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
       User::updateOrCreate([
        'email' => 'superadmin@example.com',
       ],[

       'name' => 'Super Admin',
       'password' => 'password',
       'role' => UserRole::SUPER_ADMIN,
    'company_id' => null,

       ]
       );
      
    }
}
