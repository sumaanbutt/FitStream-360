<?php

namespace App\Services;

use App\Exceptions\BusinessException;
use App\Filters\ShiftScheduleFilter;
use App\Models\ShiftSchedule;
use App\Traits\HasCode;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShiftScheduleService
{
    use HasCode;

    public function index()
    {
        return  (new ShiftScheduleFilter())
        ->apply(
            ShiftSchedule::with([
                'organization',
                'staff.user',
            ])
        );
    }

    public function store(array $data): ShiftSchedule
    {
        try {
            return DB::transaction(function () use ($data) {

//  Duplicate Working Day Check:

                $alreadyExists = ShiftSchedule::where(
                    'staff_code',
                    $data['staff_code']
                )
                    ->where(
                        'working_day',
                        $data['working_day']
                    )
                    ->where(function ($query) use ($data) {

                        $query->whereBetween('start_time', [
                            $data['start_time'],
                            $data['end_time'],
                        ])

                            ->orWhereBetween('end_time', [
                                $data['start_time'],
                                $data['end_time'],
                            ])

                            ->orWhere(function ($query) use ($data) {

                                $query->where(
                                    'start_time',
                                    '<=',
                                    $data['start_time']
                                )
                                    ->where(
                                        'end_time',
                                        '>=',
                                        $data['end_time']
                                    );
                            });
                    })
                    ->exists();

                if ($alreadyExists) {
                    throw new BusinessException('Shift timing overlaps with an existing schedule.');
                }

                $shift = ShiftSchedule::create([

                    'code' => $this->generateCode('SHF', ShiftSchedule::class),
                    'organization_code' => $data['organization_code'],
                    'staff_code' => $data['staff_code'],
                    'working_day' => $data['working_day'],
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                    'status' => $data['status'] ?? 'active',
                ]);

                return $shift->load([
                    'organization',
                    'staff.user',
                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Shift Schedule Creation Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function update(ShiftSchedule $shiftSchedule, array $data): ShiftSchedule {
        try {
            return DB::transaction(function () use ($shiftSchedule, $data) {

//  Overlap Check:
                $alreadyExists = ShiftSchedule::where(
                    'staff_code',
                    $data['staff_code'] ?? $shiftSchedule->staff_code
                )
                    ->where(
                        'working_day',
                        $data['working_day'] ?? $shiftSchedule->working_day
                    )
                    ->where('id', '!=', $shiftSchedule->id)
                    ->where(function ($query) use ($data, $shiftSchedule) {

                        $start = $data['start_time'] ?? $shiftSchedule->start_time;

                        $end = $data['end_time'] ?? $shiftSchedule->end_time;

                        $query->whereBetween('start_time', [
                            $start,
                            $end,
                        ])

                            ->orWhereBetween('end_time', [
                                $start,
                                $end,
                            ])

                            ->orWhere(function ($query) use ($start, $end) {

                                $query->where(
                                    'start_time',
                                    '<=',
                                    $start
                                )
                                    ->where(
                                        'end_time',
                                        '>=',
                                        $end
                                    );

                            });

                    })
                    ->exists();

                if ($alreadyExists) {
                    throw new BusinessException('Shift timing overlaps with an existing schedule.');
                }

                $shiftSchedule->update([
                    'organization_code' => $data['organization_code'] ?? $shiftSchedule->organization_code,
                    'staff_code' => $data['staff_code'] ?? $shiftSchedule->staff_code,
                    'working_day' => $data['working_day'] ?? $shiftSchedule->working_day,
                    'start_time' => $data['start_time'] ?? $shiftSchedule->start_time,
                    'end_time' => $data['end_time'] ?? $shiftSchedule->end_time,
                    'status' => $data['status'] ?? $shiftSchedule->status,
                ]);

                return $shiftSchedule->fresh()->load([
                    'organization',
                    'staff.user',
                ]);
            });

        } catch (\Throwable $e) {

            Log::error('Shift Schedule Update Failed', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            throw $e;
        }
    }

    public function destroy(ShiftSchedule $shiftSchedule): bool {
        try {
            return DB::transaction(function () use ($shiftSchedule) {
                $shiftSchedule->delete();

                return true;
            });

        } catch (\Throwable $e) {
            Log::error('Shift Schedule Delete Failed', [
                'message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }
}
