<?php

namespace App\Services;

use App\Models\Database;

class ValidationService
{
    public $table = '';
    public $uniqueAttribute = '';
    private $db = null;
    
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function validate($input, $toValidate)
    {
        $errors = [];
        foreach ($toValidate as $key => $requirements) {
            $errorCount = count($errors);
            foreach ($requirements as $requirement) {
                if ($errorCount < count($errors)) break;
                switch ($requirement) {
                    case 'numeric':
                        if (!is_numeric($input[$key])) {
                            $errors[$key] = ucfirst($key) . ' has to be a numeric!';
                        }
                        break;
                    case 'required':
                        if (empty($input[$key])) {
                            $errors[$key] = ucfirst($key) . ' is required!';
                        }
                        break;
                    case 'unique':
                        if (!$this->unique($input[$key])) {
                            $errors[$key] = ucfirst($key) . ' already exists in the database!';
                        }
                        break;
                    default:
                        die("{$requirement}: no such validation requirement defined!");
                }
            }
        }
        return $errors;
    }

    private function unique($identificator)
    {
        if (empty($this->table) || empty($this->uniqueAttribute)) {
            die('cannot validate uniqueness!');
        } else {
            $arr = $this->db->stmtQuery(
                "SELECT
                 COUNT(*) AS count
                 FROM {$this->table} 
                 WHERE {$this->uniqueAttribute} = :identificator", 
                 [
                'identificator' => $identificator
            ]);

            $count = $arr[0]['count'];

            return ($count > 0 ? false : true);
        }
    }
    
}