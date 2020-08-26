<?php

namespace App\Service\Validate;

use App\Repository\MySQLDatabase;

class DbValidationResource implements ValidationResourceInterface
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    public function checkUnique(string $uniqueWhere, string $uniqueWhat): bool
    {
        [$table, $field] = explode('.', $uniqueWhere);

        $arr = $this->db->query(
            "SELECT
             COUNT(*) AS count
             FROM {$table} 
             WHERE {$field} = :val", 
             [
            'val' => $uniqueWhat
        ]);

        $count = $arr[0]['count'];
        return ($count > 0 ? false : true);
    }
}
