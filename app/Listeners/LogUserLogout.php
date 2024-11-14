<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\UserSession;

class LogUserLogout
{
    public function handle(Logout $event)
    {
        $session = UserSession::where('user_id', $event->user->id)
            ->whereNull('updated_at')
            ->latest('id')
            ->first();

        if ($session) {
            $session->update(['updated_at' => now()]);
        }
    }
}
