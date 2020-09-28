<?php

namespace App\Repository\MySql\Query\Product;

use App\Helper\MySql\QueryInterface;

class ProductFullQuery implements QueryInterface
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getQuery(): string
    {
        return 
        'SELECT 
        prod.id,
        prod.name,
        AVG(r.rating) AS rating,
        COUNT(r.rating) AS number_of_ratings,
        AVG(p.price) AS price,
        COUNT(p.price) AS number_of_prices
        FROM (SELECT * FROM product WHERE id = :id) AS prod
        LEFT JOIN product_rating r ON prod.id = r.product_id
        LEFT JOIN product_price p ON prod.id = p.product_id;';
    }

    public function getParams(): array
    {
        return ['id' => $this->id];
    }
}