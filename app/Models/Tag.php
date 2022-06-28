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
     * @return array|false
     */
    public static function getAll()
    {
        $db = DB::getConection();

        $result = $db->query("SELECT * from tags ORDER BY title");
        $data = $result->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }
}