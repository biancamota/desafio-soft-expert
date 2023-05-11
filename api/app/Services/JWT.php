<?php

namespace App\Services;

use App\Http\Response;
use Config\Enviroment;
use Firebase\JWT\JWT as JWTFirebase;
use Firebase\JWT\Key;

class JWT
{
    public static function validate()
    {
        $authorization = $_SERVER['HTTP_AUTHORIZATION'];
        $key = Enviroment::getEnv('JWT_KEY');
        try {
            $token = str_replace('Bearer ', '', $authorization);
            $decode = JWTFirebase::decode($token, new Key($key, 'HS256'));
            return new Response([
                'data' => $decode
            ], 200);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], 401);
        }
    }

    public static function create($user)
    {
        $key = Enviroment::getEnv('JWT_KEY');

        $payload = [
            'exp' => time() + 3600,
            'iat' => time(),
            'data' => $user
        ];

        return JWTFirebase::encode($payload, $key, 'HS256');
    }
}
