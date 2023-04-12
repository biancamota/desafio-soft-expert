<?php

namespace App\Controllers;

use App\Http\Request;
use App\Models\User as ModelsUser;
use App\Utils\View;
use Exception;

class User extends Api
{
    public static function getByEmail(string $email)
    {
        
        $user = ModelsUser::getByEmail($email);

        if(!$user instanceof ModelsUser){
            throw new Exception("User not found", 404);           
        }

        return $user;
    }

    public static function save(Request $request)
    {
        $postVars = $request->getPostVars();

        $user = new ModelsUser();
        $user->name = $postVars['name'];
        $user->email = $postVars['email'];
        $user->password = password_hash($postVars['password'], PASSWORD_DEFAULT);
        $user->save();
        
        return [
            'id' => $user->id
        ];
    }
}
