<?php

namespace App\Http\Middleware;

use Closure;

class ExampleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $isValid = $request->header('Authorization') && $request->header('Authorization') === '123456';

        if (!$isValid) {
            return response('Acceso denegado', 401);
        }

        $response = $next($request);

        // ..

        return $response;
    }
}
