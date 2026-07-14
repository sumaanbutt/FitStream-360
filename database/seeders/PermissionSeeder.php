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
            'can-view-organization',
            'can-create-organization',
            'can-update-organization',
            'can-deactivate-organization',

            'can-view-business',
            'can-create-business',
            'can-update-business',
            'can-deactivate-business',

            'can-view-user',
            'can-create-user',
            'can-update-user',
            'can-deactivate-user',

            'can-view-staff',
            'can-create-staff',
            'can-update-staff',
            'can-deactivate-staff',

            'can-view-trainee',
            'can-create-trainee',
            'can-update-trainee',
            'can-deactivate-trainee',

            'can-view-trainee-goal',
            'can-create-trainee-goal',
            'can-update-trainee-goal',
            'can-deactivate-trainee-goal',

            'can-view-trainee-goal-attachment',
            'can-create-trainee-goal-attachment',
            'can-update-trainee-goal-attachment',
            'can-deactivate-trainee-goal-attachment',

            'can-view-location',
            'can-create-location',
            'can-update-location',
            'can-deactivate-location',

            'can-view-dietplan',
            'can-create-dietplan',
            'can-update-dietplan',
            'can-deactivate-dietplan',

            'can-view-workoutplan',
            'can-create-workoutplan',
            'can-update-workoutplan',
            'can-deactivate-workoutplan',

            'can-view-shiftschedule',
            'can-create-shiftschedule',
            'can-update-shiftschedule',
            'can-deactivate-shiftschedule',

            'can-view-category',
            'can-create-category',
            'can-update-category',
            'can-deactivate-category',

            'can-view-subcategory',
            'can-create-subcategory',
            'can-update-subcategory',
            'can-deactivate-subcategory',

            'can-view-product',
            'can-create-product',
            'can-update-product',
            'can-deactivate-product',

            'can-view-order',
            'can-create-order',
            'can-update-order',
            'can-deactivate-order',

            'can-view-invoice',
            'can-create-invoice',
            'can-update-invoice',
            'can-deactivate-invoice',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }
    }
}
