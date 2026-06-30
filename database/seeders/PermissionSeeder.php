<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{

    public function run(): void
    {
        $permissions = [
            'organization.viewAny',
            'organization.view',
            'organization.create',
            'organization.update',
            'organization.delete',

            'business.viewAny',
            'business.view',
            'business.create',
            'business.update',
            'business.delete',

            'user.viewAny',
            'user.view',
            'user.create',
            'user.update',
            'user.delete',

            'staff.viewAny',
            'staff.view',
            'staff.create',
            'staff.update',
            'staff.delete',

            'trainee.viewAny',
            'trainee.view',
            'trainee.create',
            'trainee.update',
            'trainee.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }

    }
}
