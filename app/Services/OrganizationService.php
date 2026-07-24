<?php

namespace App\Services;

use App\Filters\OrganizationFilter;
use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Traits\HasCode;

class OrganizationService
{
    use HasCode;
    public function index()
    {
//        return (new OrganizationFilter())
//            ->apply(
        return Organization::with([
            'businesses',
            'users',
        ])
            ->filter(request()->all())
            ->paginate(
                request('per_page', 10)

            );
    }

    public function store(array $data): Organization
    {
        try{
        return DB::transaction(function () use ($data) {

            $organization = Organization::create([
                'code' => $this->generateCode('XPD', Organization::class),
                'name' => $data['name'],
                'address' => $data['address'] ?? null,
                'logo' => null, // We'll implement upload later
                'status' => $data['status'],
            ]);

            $user = User::create([
                'code' => $this->generateCode('USR', User::class),
                'organization_code' => $organization->code,
                'business_code' => null,
                'name' => $data['admin_name'],
                'email' => $data['admin_email'],
                'phone' => $data['admin_phone'],
                'password' => Hash::make($data['admin_password']),
                'status' => true,
            ]);

            $user->assignRole('Organization Admin');

            return $organization;
        });

        } catch (\Throwable $e) {

            Log::error('Organization Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Organization $organization, array $data): Organization
    {
        $organization->update($data);

        return $organization->fresh();
    }

    public function destroy(Organization $organization): bool
    {
        return $organization->delete();
    }
}
