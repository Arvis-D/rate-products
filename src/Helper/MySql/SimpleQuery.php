<?php

namespace App\Helper\MySql;

use App\Helper\MySql\QueryInterface;

class SimpleQuery implements QueryInterface
{
    private $query;
    private $params = [];
    private $tableName = [];

    public function __construct($tableName)
    {
        $this->tableName = $tableName;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    public function getQuery(): string
    {
        return $this->query;
    }

    public function delete(array $where): self
    {
        $this->check($where);

        $query = "DELETE FROM {$this->tableName} WHERE ";
        $this->params = $where;

        $valueStr = '';
        foreach ($where as $key => $value) {
            $valueStr .= "{$key} = :{$key} AND ";
        }

        $valueStr = substr($valueStr, 0, -5);
        $this->query = "{$query}{$valueStr};";

        return $this;
    }

    /**
     * Only '=' operator supported
     * 
     * @param $what @example ['id', 'name'] should not be user input
     * @param $where @example ['id(should not be user input)' => '2']
     * 
     */

    public function select(array $what, array $where): self
    {
        $this->check($what);
        $this->check($where);

        $what = implode(', ', $what);
        $query = "SELECT {$what} FROM {$this->tableName} WHERE ";
        $this->params = $where;

        $valueStr = '';
        foreach ($where as $key => $value) {
            $valueStr .= "{$key} = :{$key} AND ";
        }

        $valueStr = substr($valueStr, 0, -5);
        $this->query = "{$query}{$valueStr};";

        return $this;
    }

    public function insert(array $values): self
    {
        $this->check($values);
        $query = "INSERT INTO {$this->tableName} VALUES(null";

        $valueStr = '';
        $keyVal = [];
        foreach ($values as $key => $value) {
            $key = 'key' . $key;
            $keyVal[$key] = $value;
            $valueStr .= ', :' . $key;
        }

        $this->query = "{$query}{$valueStr});";
        $this->params = $keyVal;

        return $this;
    }

    public static function table(string $tableName): self
    {
        return new self($tableName);
    }

    private function check($arr)
    {
        if (empty($arr)) {
            throw new \Exception('SimpleQuery: values should not be empty');
        }
    }
}
