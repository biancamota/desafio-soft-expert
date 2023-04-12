<?php 

namespace App\Http\Middleware;

use App\Http\Request;
use Closure;

class Api {
    public function handle(Request $request, Closure $next)
    {
        $request->getRouter()->setContentType('application/json');

        return $next($request);
    }
}