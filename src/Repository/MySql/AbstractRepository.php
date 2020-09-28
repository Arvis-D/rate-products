<?php

namespace App\Repository\MySql;

use App\Helper\MySql\SimpleQuery;
use App\Helper\MySql\Database;
use App\Helper\MySql\QueryInterface;

abstract class AbstractRepository
{
    protected SimpleQuery $table;
    protected $db;
    protected $tableName = '';
    protected $postFix = '';
    protected $subject = '';

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    protected function setTable(string $tableName)
    {
        $this->tableName = $tableName;
        $this->table = SimpleQuery::table($tableName);
    }

    protected function read(QueryInterface $query)
    {
        return $this->db->read($query);
    }

    protected function write(QueryInterface $query)
    {
        return $this->db->write($query);
    }

    protected function beginTransaction()
    {
        $this->db->pdo->beginTransaction();
    }

    protected function commit()
    {
        $this->db->pdo->commit();
    }

    public function setSubject(string $subject)
    {
        $this->subject = $subject;
        $this->tableName = $subject . $this->postFix;
        $this->setTable($this->tableName);
    }
}