<?php

namespace App\Models;

use App\DB;
use PDO;

class Tag
{
    public $id;
    public $title;

    /**
     * @param  string|null  $title
     */
    public function __construct(string $title = null)
    {
        $this->title = $title;
    }

    /**
     * @return bool
     */
    public function save()
    {
        $db = DB::getConection();

        $result = $db->query("INSERT INTO tags (title) VALUE ('$this->title')");

        return (bool) $result;
    }

    /**
     * @return array|false
     */
    public static function getAll()
    {
        $db = DB::getConection();

        $result = $db->query("SELECT * FROM tags ORDER BY title");
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    /**
     * @param  string  $tag
     *
     * @return bool
     */
    public static function exist(string $tag): bool
    {
        $db = DB::getConection();

        $query = $db->query("SELECT id FROM tags WHERE title = '$tag'");
        $tagIsset = (bool) $query->fetch(PDO::FETCH_ASSOC);

        return $tagIsset;
    }
}