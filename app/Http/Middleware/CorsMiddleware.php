<?php 

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS'); 
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, X-Requested-With, Authorization'); 
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); 

        if ($request->getMethod() == "OPTIONS") {
            $response->setStatusCode(200); 
        }

        return $response;
    }
}
