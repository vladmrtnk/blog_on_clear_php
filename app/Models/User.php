<?php

namespace App\Models;

use App\DB;
use DateTime;
use PDO;

class User
{
    public $id;
    public $name;
    public $email;
    private $password;
    public $created_at;
    public $updated_at;

    /**
     * @param  string|array|null  $name
     * @param  string|null  $email
     * @param  string|null  $password
     */
    public function __construct(string|array $name = null, string $email = null, string $password = null)
    {
        if (is_array($name)) {
            $this->name = $name['name'];
            $this->email = $name['email'];
            $this->password = $name['password'];
        } else {
            $this->name = $name;
            $this->email = $email;
            $this->password = $password;
        }
    }

    /**
     * @param  int  $needle
     *
     * @return \App\Models\User
     */
    public static function findById(int $needle)
    {
        $db = DB::getConection();

        $result = $db->query("SELECT * from users where id = $needle");
        $data = $result->fetch(PDO::FETCH_ASSOC);

        $user = new User();
        $user->id = $data['id'];
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = $data['password'];
        $user->created_at = $data['created_at'];
        $user->updated_at = $data['updated_at'];

        return $user;
    }

    /**
     * @return bool
     */
    public function save(): bool
    {
        $db = DB::getConection();

        $hash = password_hash($this->password, PASSWORD_DEFAULT);
        $created_at = (new DateTime())->format(DATE_ATOM);

        $query = $db->query("INSERT INTO users (name, email, password, created_at, updated_at) VALUES ('$this->name', '$this->email', '$hash', '$created_at', '$created_at')");

        return (bool) $query;
    }

    /**
     * @param  $password
     *
     * @return bool
     */
    public function authenticate($password): bool
    {
        $auth = password_verify($password, $this->password);

        if ($auth) {
            $_SESSION[AUTHENTICATED_USER] = $this->id;
        }

        return $auth;
    }
}