<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            'Super Admin',
            'Organization Admin',
            'Business Manager',
            'Receptionist',
            'Trainer',
            'Nutritionist',
            'Staff',
            'Trainee',
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate([
                'name' => $role,
                'guard_name' => 'api',
            ]);
        }

        $user = User::where('email', 'superadmin@xpertdigi.com')->first();

        if ($user && ! $user->hasRole('Super Admin')) {
            $user->assignRole('Super Admin');
        }

        $superAdmin = Role::findByName('Super Admin', 'api');
        $superAdmin->givePermissionTo(Permission::all());
    }
}
