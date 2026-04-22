<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Login;

class UpdateLastLoginAt
{
    public function handle(Login $event): void
    {
        $now = now();

        $event->user->updateQuietly(['last_login_at' => $now]);

        LoginLog::create([
            'user_id'    => $event->user->getKey(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'logged_in_at' => $now,
        ]);
    }
}
