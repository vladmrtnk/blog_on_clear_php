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
     * Find user by ID or Email
     *
     * @param  int|string  $needle
     *
     * @return User
     */
    public static function find($needle)
    {
        $db = DB::getConection();

        if (is_int($needle)) {
            $result = $db->query("SELECT * from users where id = $needle");
        } else {
            $result = $db->query("SELECT * from users where email = '$needle'");
        }

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
     * @param  string  $user
     *
     * @return bool
     */
    public static function exist(string $user): bool
    {
        $db = DB::getConection();

        $query = $db->query("SELECT id FROM users WHERE email = '$user'");
        $userIsset = (bool) $query->fetch(PDO::FETCH_ASSOC);

        return $userIsset;
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
        $this->id = $db->lastInsertId('users');

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