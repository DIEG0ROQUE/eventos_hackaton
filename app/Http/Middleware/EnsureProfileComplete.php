<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureProfileComplete
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // Si el usuario es participante y no tiene perfil completo
        if ($user && $user->isParticipante() && !$user->participante) {
            // Permitir acceso a las rutas de completar perfil y logout
            if (!$request->routeIs('profile.complete') && 
                !$request->routeIs('profile.store-complete') && 
                !$request->routeIs('logout')) {
                return redirect()->route('profile.complete')
                    ->with('warning', 'Por favor completa tu perfil para continuar.');
            }
        }

        return $next($request);
    }
}
