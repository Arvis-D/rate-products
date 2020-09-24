<?php

namespace App\Repository\MySql;

use App\Helper\MySQLDatabase;
use App\Repository\CommentRepositoryInterface;
use App\Repository\ProductRepositoryInterface;
use App\Repository\PictureRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    private $db;
    public $picture;
    public $comment;

    public function __construct(
        MySQLDatabase $db, 
        PictureRepositoryInterface $picture,
        CommentRepositoryInterface $comment
    ){
        $this->db = $db;
        $this->picture = $picture;
        $this->comment = $comment;
        $this->picture->setSubject('product');
        $this->comment->setSubject('product');
    }

    public function getPictureRepository(): PictureRepositoryInterface
    {
        $this->picture->setSubject('product');
        
        return $this->picture;
    }

    public function addProduct(array $product, int $userId): int
    {
        $time = time();

        $this->db->pdo->beginTransaction();

        ['name' => $name, 'price' => $price, 'rating' => $rating, 'picture' => $picture] = $product;

         $this->db->write("INSERT INTO product VALUES(null, {$userId}, :n, {$time}, {$time});", [
            'n' => $name
        ]);

        $id = $this->db->pdo->lastInsertId();

        if(!empty($price))
            $this->addPrice($id, $userId, $price);
        if(!empty($rating))
            $this->addRating($id, $userId, $rating);
        if(!empty($picture))
            $this->picture->addPicture($id, $picture, $userId);


        $this->db->pdo->commit();

        return $id;
    }

    public function addPrice(int $id, int $userId, int $price)
    {
        $time = time();
        $this->db->write("INSERT INTO product_price VALUES(null, {$id}, {$userId}, :p, {$time}, {$time});", [
            'p' => $price
        ]);
    }

    public function addRating(int $id, int $userId, int $rating)
    {
        $time = time();
        $this->db->write("INSERT INTO product_rating VALUES(null, {$id}, {$userId}, :r, {$time}, {$time});", [
            'r' => $rating
        ]);
    }

    public function getProductsBasic(): array
    {
        return $this->db->read(
            'SELECT 
                prod.id,
                prod.name,
                ANY_VALUE(pic.url) as picture,
                AVG(r.rating) AS rating,
                COUNT(DISTINCT r.id) AS number_of_ratings,
                AVG(p.price) AS price,
                COUNT(DISTINCT p.id) AS number_of_prices

                FROM product AS prod

                LEFT JOIN (SELECT * FROM product_picture ORDER BY time_created DESC) pic ON prod.id = pic.product_id
                LEFT JOIN product_rating r ON prod.id = r.product_id
                LEFT JOIN product_price p ON prod.id = p.product_id

                GROUP BY prod.id;
            '
        );
    }

    public function getAvgPriceNumberOfRecords()
    {
        return $this->db->read(
            'SELECT AVG(price) AS price, COUNT(*) AS number_of_records FROM product_price;'
        );
    }

    public function insertPictureLike(int $userId, int $pictureId, bool $like)
    {
        $like = (int) $like;
        $this->db->write("INSERT INTO product_picture_like VALUES(null, {$userId}, {$pictureId}, {$like})");
    }

    public function getProductFull(int $id): array
    {
        $product = $this->db->read(
            'SELECT 
                prod.id,
                prod.name,
                AVG(r.rating) AS rating,
                COUNT(r.rating) AS number_of_ratings,
                AVG(p.price) AS price,
                COUNT(p.price) AS number_of_prices
            FROM (SELECT * FROM product WHERE id = :i) AS prod
            LEFT JOIN product_rating r ON prod.id = r.product_id
            LEFT JOIN product_price p ON prod.id = p.product_id;',
            ['i' => $id]
        )[0];

        $pictures = $this->picture->getPictures($id);
        $product['pictures'] = $pictures;
        if (!empty($pictures)) {
            $product['randomPicture'] = 
            $this->picture->getPicture($pictures[rand(0, count($pictures) - 1)]['id']);
        }

        $product['test'] = '';

        return $product;
    }
}
