<?php

namespace App\Service\Validate;

use App\Models\Database;

class DbValidationResource implements ValidationResourceInterface
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function checkUnique(string $uniqueWhere, string $uniqueWhat): bool
    {
        [$table, $field] = explode('.', $uniqueWhat);

        $arr = $this->db->stmtQuery(
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
