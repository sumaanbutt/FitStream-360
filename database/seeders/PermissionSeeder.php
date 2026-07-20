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

            'can-view-trainee-goal-progress',
            'can-create-trainee-goal-progress',
            'can-update-trainee-goal-progress',
            'can-deactivate-trainee-goal-progress',

            'can-view-gym-goals',
            'can-create-gym-goals',
            'can-update-gym-goals',
            'can-deactivate-gym-goals',

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

            'can-view-foods',
            'can-create-foods',
            'can-update-foods',
            'can-deactivate-foods',

            'can-view-food-categories',
            'can-create-food-categories',
            'can-update-food-categories',
            'can-deactivate-food-categories',

            'can-view-dietplan-meals',
            'can-create-dietplan-meals',
            'can-update-dietplan-meals',
            'can-deactivate-dietplan-meals',

            'can-view-dietplan-meal-foods',
            'can-create-dietplan-meal-foods',
            'can-update-dietplan-meal-foods',
            'can-deactivate-dietplan-meal-foods',

            'can-view-workoutplan',
            'can-create-workoutplan',
            'can-update-workoutplan',
            'can-deactivate-workoutplan',

            'can-view-equipments',
            'can-create-equipments',
            'can-update-equipments',
            'can-deactivate-equipments',

            'can-view-exercises',
            'can-create-exercises',
            'can-update-exercises',
            'can-deactivate-exercises',

            'can-view-workoutplan-equipments',
            'can-create-workoutplan-equipments',
            'can-update-workoutplan-equipments',
            'can-deactivate-workoutplan-equipments',

            'can-view-workout-day-exercises',
            'can-create-workout-day-exercises',
            'can-update-workout-day-exercises',
            'can-deactivate-workout-day-exercises',

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
