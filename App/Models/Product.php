<?php

namespace App\Models;

class Product
{
    private $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        return $this->db->stmtQuery('SELECT * FROM products;');
    }

    public function create($proudctData)
    {
        $queryStr =
        "INSERT 
        INTO products 
        VALUES(null, :name, :price, :attributes :sku)
        ";
        
        $params = [
            'name' => $proudctData['name'],
            'attributes' => $proudctData['attributes'],
            'sku' => $proudctData['sku'],
        ];

        $this->db->stmt($queryStr, $params);
    }

    public function deleteMany($idArr)
    {
        
    }
}