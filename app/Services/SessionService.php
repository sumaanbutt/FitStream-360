<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserSession;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class SessionService
{
    /**
     * Session lifetime in minutes.
     */
    protected int $sessionLifetime = 1440; // 24 Hours

    /**
     * Create new browser session.
     */
    public function create(User $user): UserSession
    {
        try {

            return DB::transaction(function () use ($user) {

                return UserSession::create([

                    'session_code' => $this->generateSessionCode(),

                    'user_code' => $user->code,

                    'ip_address' => request()->ip(),

                    'user_agent' => request()->userAgent(),

                    'last_activity' => now(),

                    'expires_at' => now()->addMinutes(
                        $this->sessionLifetime
                    ),

                    'is_active' => true,

                ]);

            });

        } catch (\Throwable $e) {

            Log::error('Session Creation Failed', [

                'message' => $e->getMessage(),

                'file' => $e->getFile(),

                'line' => $e->getLine(),

            ]);

            throw $e;
        }
    }

    /**
     * Validate Session.
     */
    public function validate(string $sessionCode): ?UserSession
    {
        return UserSession::with('user')

            ->where('session_code', $sessionCode)

            ->where('is_active', true)

            ->where('expires_at', '>', now())

            ->first();
    }

    /**
     * Refresh Expiry Time.
     */
    public function refresh(UserSession $session): void
    {
        $session->update([

            'last_activity' => now(),

            'expires_at' => now()->addMinutes(
                $this->sessionLifetime
            ),

        ]);
    }

    /**
     * Update Activity Only.
     */
    public function updateActivity(UserSession $session): void
    {
        $session->update([

            'last_activity' => now(),

        ]);
    }

    /**
     * Logout Current Session.
     */
    public function destroy(UserSession $session): void
    {
        $session->update([

            'is_active' => false,

        ]);
    }

    /**
     * Logout All Devices.
     */
    public function destroyAll(User $user): void
    {
        UserSession::where('user_code', $user->code)

            ->update([

                'is_active' => false,

            ]);
    }

    /**
     * Generate Unique Session Code.
     */
    protected function generateSessionCode(): string
    {
        do {

            $code = Str::random(64);

        } while (

            UserSession::where(
                'session_code',
                $code
            )->exists()

        );

        return $code;
    }
}
