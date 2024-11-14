<?php

namespace App\Http\Controllers;

use App\Models\UserSession;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserSessionController extends Controller
{

    public function index()
    {
        $sessions = UserSession::with('user')->orderBy('id', 'desc')  ->get();
    
        $sessions->transform(function ($session) {
            $session->duration = $session->updated_at ? $session->created_at->diffInMinutes($session->updated_at) : 'En curso';
            return $session;
        });
    
        return view('monitoreos.index', compact('sessions'));
    }

    public function allSessions()
    {
        // Obtener todas las sesiones de los usuarios
        $sessions = UserSession::with('user')->orderBy('id', 'desc')->get();

        foreach ($sessions as $session) {
            if ($session->updated_at) {
                // Calcular la diferencia entre el login y el logout en minutos
                $session->duration = Carbon::parse($session->created_at)
                    ->diffInMinutes(Carbon::parse($session->updated_at));
            } else {
                // Si el usuario no ha cerrado sesión
                $session->duration = 'En curso';
            }
        }
        DD($sessions);

        return view('monitoreos.all_sessions', compact('sessions'));
    }
}
