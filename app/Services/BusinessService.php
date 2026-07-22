<?php

namespace App\Services;

use App\Filters\BusinessFilter;
use App\Models\Business;
use App\Models\User;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class BusinessService
{
    use HasCode;

    public function index()
    {
        return (new BusinessFilter())
            ->apply(
            Business::with('organization')
            );
    }

    public function store(array $data): Business
    {
        try {

            return DB::transaction(function () use ($data) {

                $business = Business::create([
                    'organization_code' => $data['organization_code'],
                    'code' => $this->generateCode('BUS', Business::class),
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'phone' => $data['phone'] ?? null,
//                    'discount_percentage' => $data['discount_percentage'],
//                    'agreement_start' => $data['agreement_start'],
//                    'agreement_end' => $data['agreement_end'],
                    'status' => $data['status'],
                ]);

                $user = User::create([
                    'code' => $this->generateCode('USR', User::class),
                    'organization_code' => $business->organization_code,
                    'business_code' => $business->code,
                    'name' => $data['admin_name'],
                    'email' => $data['admin_email'],
                    'phone' => $data['admin_phone'],
                    'password' => Hash::make($data['admin_password']),
                    'status' => true,
                ]);

                $user->assignRole('Business Manager');

                return $business;
            });

        } catch (\Throwable $e) {

            Log::error('Business Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Business $business, array $data): Business
    {
        $business->update($data);

        return $business->fresh();
    }

    public function destroy(Business $business): bool
    {
        return $business->delete();
    }
}
