<?php

namespace App\Service;

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

    /**
     * Will go through user input and its valdation requirements and check if they are met.
     * If a value fails to meet requirements, other validation requirements for this value
     * will not be checked further and error message will be produced.
     * 
     * it's a good idea to put 'required' requirement before anything else.
     *
     * @param array $input contains user input.
     * @param array $toValidate contains key name of the values to be validated
     *              and its validation requirements.
     * 
     * @return array $errors contains names of the values that failed validation and 
     *                their respective error messages.
     */

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
                            $errors[$key] = ucfirst($key) . ' has to be unique!';
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