<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\UserSession;

class LogUserLogin
{
    public function handle(Login $event)
    {
        // 1. Crear un nuevo registro en la tabla 'user_sessions'
        UserSession::create([
            'user_id' => $event->user->id, // El ID del usuario que acaba de iniciar sesión
            'created_at' => now(), // Establece el momento de inicio de sesión (hora actual)
            'date' => now()->toDateString(), // Guarda solo la fecha del inicio de sesión (formato YYYY-MM-DD)
        ]);
    }
}

