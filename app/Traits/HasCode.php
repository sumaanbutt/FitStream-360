<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;

trait HasCode
{
    /**
     * Generate sequential code.
     *
     * Example:
     * ORG00001
     * BUS00001
     * USR00001
     */
    protected function generateCode(string $prefix, string $model): string
    {
        $lastRecord = $model::latest('id')->first();

        $nextNumber = 1;

        if ($lastRecord && ! empty($lastRecord->code)) {
            $nextNumber = ((int) substr($lastRecord->code, strlen($prefix))) + 1;
        }

        return $prefix . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
    }
}
