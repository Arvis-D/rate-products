<?php

namespace App\Service\Validate;

use App\Helper\MySql\Database;
use App\Helper\MySql\Query;

class DbValidationResource implements ValidationResourceInterface
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function checkUnique(string $uniqueWhere, string $uniqueWhat): bool
    {
        [$table, $field] = explode('.', $uniqueWhere);
        $query = new Query(
            "SELECT
             COUNT(*) AS count
             FROM {$table} 
             WHERE {$field} = :val",
             ['val' => $uniqueWhat]
        );

        $raw = $this->db->read($query);
        $count = $raw[0]['count'];
        return ($count > 0 ? false : true);
    }
}
