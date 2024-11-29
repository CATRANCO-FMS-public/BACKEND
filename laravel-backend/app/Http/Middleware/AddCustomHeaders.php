<?php

namespace App\Http\Middleware;

use Closure;

class AddCustomHeaders
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
        $response = $next($request);
        $flespiToken = env('FLESPI_TOKEN'); // Retrieve the token from .env
        
        // Set custom headers
        $response->headers->set('Authorization', 'Bearer ' . $flespiToken);
        $response->headers->set('Custom-Header', 'CustomValue');

        return $response;
    }
}
