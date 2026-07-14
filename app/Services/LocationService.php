<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\LocationFilter;
use App\Models\Business;
use App\Models\Location;
use App\Models\Staff;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LocationService
{
    use HasCode;

    public function index()
    {
        return (new LocationFilter())
            ->apply(
            Location::with([
                'business',
                'staff.user',
            ])
        );
    }

    public function store(array $data): Location
    {
        try {
            return DB::transaction(function () use ($data) {

                if (
                    $data['type'] === 'business' &&
                    ! empty($data['staff_code'])
                ) {
                    throw new BusinessException('Business location cannot have a staff.');
                }

                if (
                    $data['type'] === 'staff' &&
                    empty($data['staff_code'])
                ) {
                    throw new BusinessException('Staff location requires a staff.');
                }


                if ($data['type'] === 'staff') {

                    $staff = Staff::where(
                        'code',
                        $data['staff_code']
                    )->firstOrFail();

//                    if (
//                        $business->organization_code !==
//                        $staff->organization_code
//                    ) {
//                        throw new BusinessException('Selected staff does not belong to the selected organization.');
//                    }
                }

                $location = Location::create([

                    'code' => $this->generateCode('LOC', Location::class),
                    'business_code' => $data['type'] === 'business'
                        ? $data['business_code']
                        : null,

                    'staff_code' => $data['type'] === 'staff'
                        ? $data['staff_code']
                        : null,

                    'location_type' => $data['type'],
                    'address' => $data['address'],
                    'city' => $data['city'],
                    'state' => $data['state'],
                    'country' => $data['country'],
                    'postal_code' => $data['postal_code'],
                    'location_status' => $data['status'] ?? 'active',
                ]);

                return $location->load([
                    'business',
                    'staff.user',
                ]);
            });
        } catch (\Throwable $e) {

            Log::error('Location Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function update(Location $location, array $data): Location {
        try {
            return DB::transaction(function () use ($location, $data) {

                $locationType = $data['location_type'] ?? $location->location_type;
                $businessCode = $data['business_code'] ?? $location->business_code;
                $staffCode = $data['staff_code'] ?? $location->staff_code;

                if (
                    $locationType === 'business' &&
                    ! empty($staffCode)
                ) {
                    throw new BusinessException('Business location cannot have a staff.');
                }

                if (
                    $locationType === 'staff' &&
                    empty($staffCode)
                ) {
                    throw new BusinessException('Staff location requires a staff.');
                }

                if ($locationType === 'staff') {

                    $business = Business::where(
                        'code',
                        $businessCode
                    )->firstOrFail();

                    $staff = Staff::where(
                        'code',
                        $staffCode
                    )->firstOrFail();

                    if (
                        $business->organization_code !==
                        $staff->organization_code
                    ) {
                        throw new BusinessException('Selected staff does not belong to the selected organization.');
                    }
                }

                $location->update([
                    'business_code' => $businessCode,
                    'staff_code' => $locationType === 'business'
                        ? null
                        : $staffCode,

                    'type' => $locationType,
                    'address' => $data['address'] ?? $location->address,
                    'city' => $data['city'] ?? $location->city,
                    'state' => $data['state'] ?? $location->state,
                    'country' => $data['country'] ?? $location->country,
                    'postal_code' => $data['postal_code'] ?? $location->postal_code,
                    'status' => $data['status'] ?? $location->status,
                ]);

                return $location->fresh()->load([
                    'business',
                    'staff.user',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Location Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function destroy(Location $location): bool {
        try {
            return DB::transaction(function () use ($location) {

                $location->delete();
                return true;
            });

        } catch (\Throwable $e) {

            Log::error('Location Delete Failed', [
                'message' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
