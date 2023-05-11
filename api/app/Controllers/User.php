<?php

namespace App\Controllers;

use App\Http\Response;
use App\Models\User as ModelsUser;
use Exception;

class User
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new ModelsUser();
    }
    public function getByEmail(string $email)
    {
        try {
            $user = $this->userModel->getByEmail($email);

            if (empty($user)) {
                throw new Exception("User not found", 404);
            }

            return new Response([
                'success' => true,
                'data' => [
                    'user' => $user
                ]
            ]);
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }

    public function save($request)
    {
        try {

            $userExists = $this->userModel->getByEmail($request->email);

            if (!$userExists) {
                $id = $this->userModel->save([
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => password_hash(trim($request->password), PASSWORD_DEFAULT)
                ]);

                if (!$id) {
                    throw new Exception("Unable to save user. Please try again later or contact support", 500);
                }
                return new Response([
                    'success' => true,
                    'data' => [
                        'id' => $id
                    ]
                ]);
            }
            throw new Exception("User already registered", 400);
            
        } catch (\Throwable $th) {
            return new Response([
                'error' => $th->getCode(),
                'message' => $th->getMessage()
            ], $th->getCode());
        }
    }
}
