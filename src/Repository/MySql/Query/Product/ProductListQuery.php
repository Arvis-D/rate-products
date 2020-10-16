<?php

namespace App\Repository\MySql\Query\Product;

use App\Helper\MySql\QueryInterface;

class ProductListQuery implements QueryInterface
{
    public function getQuery(): string
    {
        return 
        'SELECT 
        prod.id,
        prod.name,
        ANY_VALUE(pic.url) as picture,
        AVG(r.rating) AS rating,
        COUNT(DISTINCT r.id) AS number_of_ratings,
        AVG(p.price) AS price,
        COUNT(DISTINCT p.id) AS number_of_prices,
        t.name as type

        FROM product AS prod

        LEFT JOIN (SELECT * FROM product_picture ORDER BY time_created DESC) pic ON prod.id = pic.product_id
        LEFT JOIN product_rating r ON prod.id = r.product_id
        LEFT JOIN product_price p ON prod.id = p.product_id
        INNER JOIN product_type t ON prod.type_id = t.id

        GROUP BY prod.id;';
    }

    public function getParams(): array
    {
        return [];
    }
}
