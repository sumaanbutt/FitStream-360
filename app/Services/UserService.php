<?php

namespace App\Services;

use App\Models\User;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserService
{
    use HasCode;

    public function index()
    {
        return User::with([
            'organization',
            'business',
            'roles',
        ])
            ->latest()
            ->paginate(10);
    }

    public function store(array $data): User
    {
        try {
            return DB::transaction(function () use ($data) {

                $user = User::create([
                    'organization_code' => $data['organization_code'],
                    'business_code' => $data['business_code'] ?? null,

                    'code' => $this->generateCode('USR', User::class),

                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'],

                    'password' => Hash::make($data['password']),

                    'status' => $data['status'],
                ]);

                $user->assignRole($data['role']);
                return $user;
            });

        } catch (\Throwable $e) {

            Log::error('User Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function createUser(array $data): User
    {
        return $this->store($data);
    }


    public function update(User $user, array $data): User
    {
        try {

            return DB::transaction(function () use ($user, $data) {

                if (isset($data['password'])) {
                    $data['password'] = Hash::make($data['password']);
                }

                $user->update($data);

                if (isset($data['role'])) {

                    $user->syncRoles([
                        $data['role']
                    ]);

                }

                return $user->fresh();

            });

        } catch (\Throwable $e) {

            Log::error('User Update Failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function destroy(User $user): bool
    {
        try {
            return DB::transaction(function () use ($user) {

                $user->delete();

                return true;

            });

        } catch (\Throwable $e) {

            Log::error('User Delete Failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    public function register(array $data): User
    {
        return User::create([
            'code' => $this->generateCode('USR', User::class),

            'organization_code' => null,
            'business_code' => null,

            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],

            'password' => Hash::make($data['password']),
            'status' => true,
        ]);
    }
}
