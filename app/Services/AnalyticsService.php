<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Business;
use App\Models\Category;
use App\Models\DietPlan;
use App\Models\Equipment;
use App\Models\Exercise;
use App\Models\Location;
use App\Models\Order;
use App\Models\Organization;
use App\Models\Product;
use App\Models\Staff;
use App\Models\Trainee;
use App\Models\User;
use App\Models\WorkoutPlan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AnalyticsService
{
    public function overview(): array
    {
        return [
            'total_organizations' => $this->count(Organization::class),
            'total_businesses'    => $this->count(Business::class),
            'total_locations'     => $this->count(Location::class),
            'total_users'         => $this->count(User::class),
            'total_staff'         => $this->count(Staff::class),
            'total_trainees'      => $this->count(Trainee::class),
            'total_products'      => $this->count(Product::class),
            'total_orders'        => $this->count(Order::class),
        ];
    }

    public function organization(): array
    {
        return [
            'total_organizations' => $this->count(Organization::class),
            'total_businesses'    => $this->count(Business::class),
            'total_locations'     => $this->count(Location::class),
            'total_roles'         => $this->count(Role::class),
            'total_permissions'   => $this->count(Permission::class),
        ];
    }

    public function users(): array
    {
        return [
            'total_users'          => $this->count(User::class),
            'total_staff'          => $this->count(Staff::class),
            'total_trainers'       => $this->countByColumn(
                Staff::class,
                'staff_type',
                'trainer'
            ),
            'total_trainees'       => $this->count(Trainee::class),
            'active_users'         => $this->countByColumn(
                User::class,
                'status',
                'active'
            ),
            'inactive_users'       => $this->countByColumn(
                User::class,
                'status',
                'inactive'
            ),
        ];
    }

    public function attendance(): array
    {
        return [
            'present_today' => Attendance::whereDate(
                'attendance_date',
                today()
            )
                ->where('status', 'present')
                ->count(),

            'absent_today' => Attendance::whereDate(
                'attendance_date',
                today()
            )
                ->where('status', 'absent')
                ->count(),

            'late_today' => Attendance::whereDate(
                'attendance_date',
                today()
            )
                ->where('status', 'late')
                ->count(),
        ];
    }

    public function fitness(): array
    {
        return [
            'total_workout_plans' => $this->count(WorkoutPlan::class),
            'total_diet_plans'    => $this->count(DietPlan::class),
            'total_equipment'     => $this->count(Equipment::class),
            'total_exercises'     => $this->count(Exercise::class),
        ];
    }

    public function inventory(): array
    {
        return [
            'total_categories' => $this->count(Category::class),
            'total_products'   => $this->count(Product::class),
        ];
    }

    public function orders(): array
    {
        return [
            'total_orders' => $this->count(Order::class),

            'pending_orders' => $this->countByColumn(
                Order::class,
                'status',
                'pending'
            ),

            'delivered_orders' => $this->countByColumn(
                Order::class,
                'status',
                'delivered'
            ),
        ];
    }

    public function finance(): array
    {
        return [
            'total_profit' => 0,
            'total_loss'   => 0,
            'chart'        => $this->profitLossChart(),
        ];
    }

    private function count(string $model): int
    {
        return $model::count();
    }

    private function countByColumn(
        string $model,
        string $column,
        mixed $value
    ): int {
        return $model::where($column, $value)->count();
    }

    private function profitLossChart(): array
    {
        return [];
    }
}
