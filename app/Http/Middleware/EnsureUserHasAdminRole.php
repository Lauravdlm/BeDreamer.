<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware para verificar que un usuario tiene el rol de Administrador.
 * @package App\Middleware
 */
class EnsureUserHasAdminRole
{
    /**
     * Manejar que los datos de un usuario que nos llegan tiene el rol de administrador.
     *
     * @param Request $request Usuario
     * @param  \Closure  $next Función de cierre del middleware
     *
     * @return mixed En caso de éxito se continuará con la ejecución del programa | En caso de error redirección
     */
    public function handle(Request $request, Closure $next): mixed
    {
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            // Verificar si el usuario tiene el rol de administrador
            if (Auth::user()->role_id === 1) { // ID del rol de administrador es 1
                return $next($request);
            }
        }
        // Si el usuario no tiene el rol de administrador, redirigir a una página de acceso no autorizado
        return redirect()->route('home')->with('error', 'Acceso no autorizado');
        // return new RedirectResponse(route('home'));
    }
}
