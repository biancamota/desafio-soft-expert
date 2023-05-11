<?php

namespace App\Models;

use Exception;

class User extends BaseModel
{
    protected $table = 'users';

    public function getByEmail(string $email)
    {
        $user = $this->qb->where('email', '=', $email)->first();

        if ($user) {
            return $user;
        }

        return false;
    }
}