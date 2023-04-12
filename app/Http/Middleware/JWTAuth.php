<?php

namespace App\Http\Middleware;

use App\Http\Request;
use App\Models\User;
use Closure;

class JWTAuth
{

    private function getJWTAuthUser(Request $request)
    {
        $headers = $request->getHeaders();
        echo '<pre>'; 
        print_r($headers);
        echo '</pre>'; 
        $user = User::getByEmail($_SERVER['PHP_AUTH_USER']);

        if (!$user instanceof User) {
            return false;
        }

        return password_verify($_SERVER['PHP_AUTH_PW'], $user->password) ? $user : false;
    }

    private function auth(Request $request)
    {
        if ($user = $this->getJWTAuthUser($request)) {
            $request->user = $user;
            return true;
        }
    }
    public function handle(Request $request, Closure $next)
    {
        $this->auth($request);

        return $next($request);
    }
}
