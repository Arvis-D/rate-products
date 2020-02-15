<?php

namespace App\Models;

class ProductModel
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
        VALUES(null, :type, :price, :attributes, :name, :sku);
        ";
        
        $params = [
            'type' => $proudctData['type'],
            'price' => $proudctData['price'],
            'attributes' => $proudctData['attributes'],
            'name' => $proudctData['name'],
            'sku' => $proudctData['sku'],
        ];

        $this->db->stmt($queryStr, $params);
    }

    public function deleteMany($idArr)
    {
        
    }
}