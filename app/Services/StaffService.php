<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\StaffFilter;
use App\Models\Staff;
use App\Models\User;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StaffService
{
    use HasCode;

    public function __construct(
        protected UserService $userService
    ) {}

    public function index()
    {
        return (new StaffFilter())
        ->apply(
            Staff::with([
                'user',
                'business',
            ])
        );
    }

    public function store(array $data): Staff
    {
        try {

            return DB::transaction(function () use ($data) {
                if (
                    isset($data['user_type']) &&
                    $data['user_type'] === 'existing'
                ) {

                    $user = User::where('code', $data['user_code'])->firstOrFail();

                    $user->update([
                        'organization_code' => $data['organization_code'],
                        'business_code' => $data['business_code']
                        ]);

                    $user->syncRoles(
                        [$data['role']
                    ]);

                } else {
                    $user = $this->userService->createUser([
                        'organization_code' => $data['organization_code'],
                        'business_code' => $data['business_code'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'] ?? null,
                        'password' => $data['password'],
                        'status' => $data['status'],
                        'role' => $data['role'],
                    ]);
                }

                if (Staff::where('user_code', $user->code)->exists()) {
                    throw new BusinessException('This user is already assigned as staff.');
                }

                $staff = Staff::create([
                    'code' => $this->generateCode('STF', Staff::class),
                    'business_code' => $data['business_code'],
                    'user_code' => $user->code,
                    'salary' => $data['salary'],
                    'certifications' => $data['certifications'] ?? null,
                    'experience' => $data['experience'] ?? 0,
                    'joining_date' => $data['joining_date'],
                    'status' => $data['status'],
                ]);

                return $staff->load([
                    'user',
                    'business',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Staff Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Staff $staff, array $data): Staff
    {
        try {
            return DB::transaction(function () use ($staff, $data) {
                $user = $staff->user;

                $this->userService->update(
                    $user,
                    $data
                );

                $staff->update([
                    'business_code' => $data['business_code'],
                    'salary' => $data['salary'],
                    'certifications' => $data['certifications'] ?? null,
                    'experience' => $data['experience'] ?? 0,
                    'joining_date' => $data['joining_date'],
                    'status' => $data['status'],
                ]);

                return $staff->fresh()->load([
                    'user',
                    'business',
                ]);
            });

        } catch (\Throwable $e) {
            Log::error('Staff Update Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    public function destroy(Staff $staff): bool
    {
        try {

            return DB::transaction(function () use ($staff) {
                $staff->delete();
                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Staff Delete Failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
