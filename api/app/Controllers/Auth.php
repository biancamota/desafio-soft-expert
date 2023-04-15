<?php

namespace App\Controllers;

use App\Http\Response;
use App\Services\JWT;

class Auth
{
    public function auth($request)
    {
        //buscar user por email
        $user = false;

        if (!$user) {
            return new Response([
                'error' => 401,
                'message' => 'Not authorized'
            ], 401);
        }

        if (!password_verify($request->password, $user->password)) {
            return new Response([
                'error' => 401,
                'message' => 'Not authorized'
            ], 401);
        }

        $token = JWT::create($user);

        return new Response([
            'token' => $token,
            'user' => $user->name
        ]);
    }
}
