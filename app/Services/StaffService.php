<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\StaffFilter;
use App\Models\Staff;
use App\Models\Trainer;
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
                'trainer'
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

                $staffType = strtolower($data['role']) === 'trainer'
                    ? 'trainer'
                    : 'operational';

                $staff = Staff::create([
                    'code' => $this->generateCode('STF', Staff::class),
                    'business_code' => $data['business_code'],
                    'user_code' => $user->code,
                    'staff_type' => $staffType,
                    'salary' => $data['salary'],
                    'cnic' => $data['cnic'] ?? null,
                    'blood_group' => $data['blood_group'] ?? null,
                    'emergency_contact_name' => $data['emergency_contact_name'] ?? null,
                    'emergency_contact_phone' => $data['emergency_contact_phone'] ?? null,
                    'joining_date' => $data['joining_date'],
                    'status' => $data['status'],
                ]);

                if ($staffType === 'trainer') {

                    Trainer::create([
                        'code' => $this->generateCode('TRN', Trainer::class),
                        'business_code' => $staff->business_code,
                        'staff_code' => $staff->code,
                        'experience' => $data['experience'],
                        'certifications' => $data['certifications'],
                        'specialization' => $data['specialization'] ?? null,
                        'bio' => $data['bio'] ?? null,
                        'status' => $staff->status,
                    ]);
                }

                return $staff->load([
                    'user',
                    'business',
                    'trainer'
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

                $userData = [
                    'organization_code' => $data['organization_code'] ?? $user->organization_code,
                    'business_code'     => $data['business_code'] ?? $user->business_code,
                    'name'              => $data['name'] ?? $user->name,
                    'email'             => $data['email'] ?? $user->email,
                    'phone'             => $data['phone'] ?? $user->phone,
                    'status'            => $data['status'] ?? $user->status,
                    'role'              => $data['role'] ?? $user->getRoleNames()->first(),
                ];

                if (!empty($data['password'])) {
                    $userData['password'] = $data['password'];
                }

                $this->userService->update($user, $userData);

                //check type:

                $role = $data['role'] ?? $user->getRoleNames()->first();

                $staffType = strtolower($role) === 'trainer'
                    ? 'trainer'
                    : 'operational';

                $staff->update([
                    'business_code'             => $data['business_code'] ?? $staff->business_code,
                    'staff_type'                => $staffType,
                    'salary'                    => $data['salary'] ?? $staff->salary,
                    'cnic'                      => $data['cnic'] ?? $staff->cnic,
                    'blood_group'               => $data['blood_group'] ?? $staff->blood_group,
                    'emergency_contact_name'    => $data['emergency_contact_name'] ?? $staff->emergency_contact_name,
                    'emergency_contact_phone'   => $data['emergency_contact_phone'] ?? $staff->emergency_contact_phone,
                    'joining_date'              => $data['joining_date'] ?? $staff->joining_date,
                    'status'                    => $data['status'] ?? $staff->status,
                ]);


                if ($staffType === 'trainer') {

                    Trainer::updateOrCreate([
                            'staff_code' => $staff->code,
                        ],

                        [
                            'business_code' => $staff->business_code,
                            'experience' => $data['experience'] ?? optional($staff->trainer)->experience,
                            'certifications' => $data['certifications'] ?? optional($staff->trainer)->certifications,
                            'specialization' => $data['specialization'] ?? optional($staff->trainer)->specialization,
                            'bio' => $data['bio'] ?? optional($staff->trainer)->bio,
                            'status' => $staff->status,
                        ]
                    );

                } else {
                    $staff->trainer()?->delete();
                }

                return $staff->fresh()->load([
                    'user',
                    'business',
                    'trainer',
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
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }
}
