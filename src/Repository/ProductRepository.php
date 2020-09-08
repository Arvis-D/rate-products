<?php

namespace App\Repository;

use App\Repository\MySQLDatabase;

class ProductRepository
{
    private $db;

    public function __construct(MySQLDatabase $db)
    {
        $this->db = $db;
    }

    public function insertNewProduct(string $name, int $userId): int
    {
        $time = time();
        $this->db->sql("INSERT INTO product VALUES(null, {$userId}, :n, {$time}, {$time});", [
            'n' => $name
        ]);
       
       return $this->db->pdo->lastInsertId();
    }

    public function insertNewPrice(int $price, int $productId, int $userId)
    {
        $time = time();
        $this->db->sql("INSERT INTO product_price VALUES(null, {$productId}, {$userId}, :p, {$time}, {$time});", [
            'p' => $price
        ]);
    }

    public function insertNewRating(int $rating, int $productId, int $userId)
    {
        $time = time();
        $this->db->sql("INSERT INTO product_rating VALUES(null, {$productId}, {$userId}, :r, {$time}, {$time});", [
            'r' => $rating
        ]);
    }

    public function insertNewPicture(string $pictureUrl, int $productId, int $userId)
    {
        $time = time();
        $this->db->sql("INSERT INTO product_picture VALUES(null, {$productId}, {$userId}, :p, {$time});", [
            'p' => $pictureUrl
        ]);
    }

    public function insertNewComment(string $comment, int $productId, int $userId)
    {
        $time = time();
        $this->db->sql("INSERT INTO product_comment VALUES(null, {$productId}, {$userId}, :c, {$time}, {$time});", [
            'c' => $comment
        ]);
    }

    public function getProductsWithBasicInfo()
    {
        return $this->db->sqlFetch(
            'SELECT 
                prod.name,
                prod.id, 
                AVG(r.rating) AS rating,
                COUNT(r.rating) AS number_of_ratings,
                AVG(p.price) AS price,
                COUNT(p.price) AS number_of_prices,
                ANY_VALUE(pic.picture) as picture

                FROM product AS prod

                LEFT JOIN product_rating r ON prod.id = r.product_id
                LEFT JOIN product_price p ON prod.id = p.product_id
                LEFT JOIN product_picture pic ON prod.id = pic.product_id

                GROUP BY prod.id;
            '
        );
    }

    public function selectAvgPriceNumberOfRecords()
    {
        return $this->db->sqlFetch(
            'SELECT AVG(price) AS price, COUNT(*) AS number_of_records FROM product_price;'
        );
    }

    public function fetchProducInfo(int $id)
    {
        $this->db->sql(
            'CREATE TEMPORARY TABLE t_product_comment SELECT * FROM product_comment WHERE product_id = :i;',
            ['i' => $id]
        );
        $this->db->sql(
            'CREATE TEMPORARY TABLE t_product_picture SELECT * FROM product_picture WHERE product_id = :i;',
            ['i' => $id]
        );

        $comments = $this->db->sqlFetch('SELECT * FROM t_product_picture');
        $pictures = $this->db->sqlFetch('SELECT * FROM t_product_comment');

        $product = $this->db->sqlFetch(
            'SELECT 
                prod.name,
                AVG(r.rating) AS rating,
                COUNT(r.rating) AS number_of_ratings,
                AVG(p.price) AS price,
                COUNT(p.price) AS number_of_prices

                FROM (SELECT * FROM product WHERE id = :i) AS prod

                LEFT JOIN product_rating r ON prod.id = r.product_id
                LEFT JOIN product_price p ON prod.id = p.product_id;
                ',
                ['i' => $id]
        )[0];

        $product['comments'] = $comments;
        $product['pictures'] = $pictures;

        return $product;
    }
}
