<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\User;
use App\Services\JWT;
use Firebase\JWT\JWT as JWTJWT;

class Auth
{
    public function auth($request)
    {
        $userModel = new User();
        $user = $userModel->getByEmail(strip_tags($request->email));
        
        if (!$user) {
            return new Response([
                'error' => 401,
                'message' => 'Not authorized'
            ], 401);
        }

        if (!password_verify(strip_tags($request->password), $user['password'])) {
            return new Response([
                'error' => 401,
                'message' => 'Not authorized'
            ], 401);
        }

        $token = JWT::create($user);

        return new Response([
            'token' => $token,
            'user' => $user['name'],
            'message' => 'LoggedIn'
        ]);
    }

    public function verify()
    {
        return JWT::validate();
    }
}
