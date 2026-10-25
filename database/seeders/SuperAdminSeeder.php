<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => env('ADMIN_EMAIL', 'admin@example.com')],
            [
                'name' => 'Super Admin',
                'password' => env('ADMIN_PASSWORD', 'ChangeMe123!'), // hashed by the model cast; change it after the first login
                'account_type' => 'admin',
                'account_status' => 'active',
                'email_verified_at' => now(),
            ]
        );

        $role = Role::where('name', 'super_admin')->firstOrFail();
        $admin->roles()->syncWithoutDetaching([
            $role->id => ['company_id' => null, 'assigned_at' => now()],
        ]);
    }
}
