<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\TraineeFilter;
use App\Models\Trainee;
use App\Models\User;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class TraineeService
{
    use HasCode;
    public function __construct(
        protected UserService $userService
    ){}

    public function index()
    {
        return (new TraineeFilter())
        ->apply(
            Trainee::with([
                'user',
                'organization',
                'business',
            ])
        );
    }

    public function store(array $data): Trainee
    {
        try {
            return DB::transaction(function () use ($data) {

                if ($data['user_type'] === 'existing') {
                    $user = User::where('code', $data['user_code'])
                        ->firstOrFail();

                    $user->update([
                        'organization_code' => $data['organization_code'],
                        'business_code' => $data['business_code'],
                    ]);

                    $user->syncRoles([
                        'Trainee',
                    ]);

                } else {
                    $user = $this->userService->store([
                        'organization_code' => $data['organization_code'],
                        'business_code' => $data['business_code'],
                        'name' => $data['name'],
                        'email' => $data['email'],
                        'phone' => $data['phone'] ?? null,
                        'password' => $data['password'],
                        'status' => $data['status'],
                        'role' => 'Trainee',
                    ]);
                }

                if (
                    Trainee::where('user_code', $user->code)->exists()
                ) {
                    throw new BusinessException('This user is already registered as a trainee.');
                }

                $trainee = Trainee::create([

                    'code' => $this->generateCode('TRN', Trainee::class),
                    'business_code' => $data['business_code'],
                    'organization_code' => $data['organization_code'],
                    'user_code' => $user->code,
                    'gender' => $data['gender'] ?? null,
                    'age' => $data['age'] ?? null,
                    'height' => $data['height'] ?? null,
                    'weight' => $data['weight'] ?? null,
                    'joining_date' => $data['joining_date'],
                    'status' => $data['status'],
                ]);

                return $trainee->load([
                    'user',
                    'organization',
                    'business',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Trainee Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function update(Trainee $trainee, array $data): Trainee
    {
        try {
            return DB::transaction(function () use ($trainee, $data) {

                $user = $trainee->user;

                $this->userService->update($user, [
                    'organization_code' => $data['organization_code'] ?? $user->organization_code,
                    'business_code' => $data['business_code'] ?? $user->business_code,
                    'name' => $data['name'] ?? $user->name,
                    'email' => $data['email'] ?? $user->email,
                    'phone' => $data['phone'] ?? $user->phone,
                    'password' => $data['password'] ?? null,
                    'role' => 'Trainee',
                    'status' => $data['status'] ?? $user->status,
                ]);

                $trainee->update([
                    'business_code' => $data['business_code'] ?? $trainee->business_code,
                    'gender' => $data['gender'] ?? $trainee->gender,
                    'age' => $data['age'] ?? $trainee->age,
                    'height' => $data['height'] ?? $trainee->height,
                    'weight' => $data['weight'] ?? $trainee->weight,
                    'joining_date' => $data['joining_date'] ?? $trainee->joining_date,
                    'status' => $data['status'] ?? $trainee->status,
                ]);

                return $trainee->fresh()->load([
                    'user',
                    'organization',
                    'business',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Trainee Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            throw $e;
        }
    }

    public function destroy(Trainee $trainee) : bool
    {
        try {

            return DB::transaction(function () use ($trainee) {
                $trainee->delete();
                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Trainee Delete Failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
