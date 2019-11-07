<?php

namespace App\Http\Middleware;

use Closure;

class HttpsProtocol
{
    /**
     * Redireccionamos a HTTPS si estamos
     * en producción y no estamos en HTTPS
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->secure() && App::environment() === 'production') {
            return redirect()->secure($request->getRequestUri());
        }

        return $next($request);
    }
}
