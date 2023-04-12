<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\User;
use Exception;
use Firebase\JWT\JWT;
use WilliamCosta\DatabaseManager\Pagination;

class Auth extends Api
{
    public static function generateToken(Request $request)
    {
        $postVars = $request->getPostVars();

        if(!isset($postVars['email']) || !isset($postVars['password'])) {
            throw new Exception("Unauthorized access. Please provide credentials to access this resource.", 401);            
        }

        $user = User::getByEmail($postVars['email']);

        if(!$user instanceof User || password_verify($postVars['password'], $user->password)) {
            throw new Exception("Unauthorized access. Please provide valid credentials to access this resource.", 401);            
        }

        $payload = [
            'email' => $user->email
        ];

        return [
            'token' => JWT::encode($payload, $key)
        ];
    }
}
