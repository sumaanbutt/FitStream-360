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

            'trainee-goal.viewAny',
            'trainee-goal.view',
            'trainee-goal.create',
            'trainee-goal.update',
            'trainee-goal.delete',

            'trainee-goal-attachment.viewAny',
            'trainee-goal-attachment.view',
            'trainee-goal-attachment.create',
            'trainee-goal-attachment.update',
            'trainee-goal-attachment.delete',

            'location.viewAny',
            'location.view',
            'location.create',
            'location.update',
            'location.delete',

            'dietplan.viewAny',
            'dietplan.view',
            'dietplan.create',
            'dietplan.update',
            'dietplan.delete',

            'workout.viewAny',
            'workout.view',
            'workout.create',
            'workout.update',
            'workout.delete',

            'shiftschedule.viewAny',
            'shiftschedule.view',
            'shiftschedule.create',
            'shiftschedule.update',
            'shiftschedule.delete',

            'category.viewAny',
            'category.view',
            'category.create',
            'category.update',
            'category.delete',

            'subcategory.viewAny',
            'subcategory.view',
            'subcategory.create',
            'subcategory.update',
            'subcategory.delete',

            'product.viewAny',
            'product.view',
            'product.create',
            'product.update',
            'product.delete',

            'order.viewAny',
            'order.view',
            'order.create',
            'order.update',
            'order.delete',

            'invoice.viewAny',
            'invoice.view',
            'invoice.create',
            'invoice.update',
            'invoice.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::findOrCreate($permission, 'api');
        }
    }
}
