<?php

namespace App\Models;

use App\Factory;

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
        $stmtStr =
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

        $this->db->stmt($stmtStr, $params);
    }

    public function deleteMany($idArr)
    {
        $idArr = (array) json_decode($idArr);
        $params = [];
        $stmtStr = "DELETE FROM products WHERE id IN(";
        foreach ($idArr as $key => $id) {
            if ($key === 0) $stmtStr .= ":id{$id} ";
            else $stmtStr .= ",:id{$id} ";
            $params["id{$id}"] = $id;
        }
        $stmtStr .= ');';
        
        $this->db->stmt($stmtStr, $params);
    }

    public static function getInst($name = 'basic')
    {
        return Factory::make($name, self::class, function () {
            return new ProductModel(
                Database::getInst()
            );
        });
    }
}