<?php

namespace App\Services;

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
    public function getAll()
    {
        return Organization::latest()->paginate(10);
    }

    /**
     * Create Organization with Organization Admin.
     */
    public function store(array $data): Organization
    {
        try{
        return DB::transaction(function () use ($data) {

            $organization = Organization::create([
                'code' => $this->generateCode('FTS', Organization::class),
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

    /**
     * Update Organization.
     */
    public function update(Organization $organization, array $data): Organization
    {
        $organization->update($data);

        return $organization->fresh();
    }

    /**
     * Delete Organization.
     */
    public function destroy(Organization $organization): bool
    {
        return $organization->delete();
    }
}
