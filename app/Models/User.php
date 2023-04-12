<?php

namespace App\Models;

use PDO;
use WilliamCosta\DatabaseManager\Database;

class User
{
    public static string $table = 'users';
    public int $id;
    public string $name;
    public string $email;
    public string $password;

    public static function getByEmail(string $email)
    {
        return (new Database(self::$table))->select('email = ' . $email, null, 1, '*')->fetchAll(PDO::FETCH_ASSOC);
    }

    public function save()
    {
        echo '<pre>'; 
        print_r($this);
        echo '</pre>';die; 
        $this->id = (new Database($this->table))->insert([
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password
        ]);

        return $this->id;
    }

}
