<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $superAdmin = Role::findByName('Super Admin', 'api');
        $organizationAdmin = Role::findByName('Organization Admin', 'api');
        $businessManager = Role::findByName('Business Manager', 'api');
        $receptionist = Role::findByName('Receptionist', 'api');
        $trainer = Role::findByName('Trainer', 'api');

        $superAdmin->syncPermissions(Permission::all());

        $organizationAdmin->syncPermissions([
            'can-view-business',
            'can-create-business',
            'can-update-business',

            'can-view-user',
            'can-create-user',
            'can-update-user',

            'can-view-staff',
            'can-create-staff',
            'can-update-staff',
        ]);

        $businessManager->syncPermissions([
            'can-view-user',
            'can-create-user',

            'can-view-staff',
            'can-create-staff',
            'can-update-staff',

            'can-view-trainee',
            'can-create-trainee',
            'can-update-trainee',

            'can-view-product',
            'can-create-product',

            'can-view-order',
            'can-create-order',
        ]);

        $receptionist->syncPermissions([
            'can-view-trainee',
            'can-create-trainee',

            'can-view-order',
            'can-create-order',

            'can-view-invoice',
        ]);

        $trainer->syncPermissions([
            'can-view-trainee',
            'can-update-trainee',

            'can-view-workoutplan',
            'can-create-workoutplan',
            'can-update-workoutplan',
        ]);
    }
}

