<?php

namespace App\Repository\MySql;

use App\Helper\MySql\Database;
use App\Helper\MySql\Query;
use App\Helper\MySql\SimpleQuery;
use App\Repository\CommentRepositoryInterface;
use App\Repository\MySql\Query\Product\ProductFullQuery;
use App\Repository\MySql\Query\Product\ProductListQuery;
use App\Repository\ProductRepositoryInterface;
use App\Repository\PictureRepositoryInterface;

class ProductRepository extends AbstractRepository implements ProductRepositoryInterface
{
    private $picture;
    private $comment;

    public function __construct(
        Database $db, 
        PictureRepositoryInterface $picture,
        CommentRepositoryInterface $comment
    ){
        parent::__construct($db);
        $this->db = $db;
        $this->picture = $picture;
        $this->comment = $comment;
        $this->setTable('product');
    }

    public function getPictureRepository(): PictureRepositoryInterface
    {
        $this->picture->setSubject($this->tableName);
        
        return $this->picture;
    }

    public function addProduct(array $product, int $userId): int
    {
        $time = time();

        $this->beginTransaction();

        $this->write($this->table->insert([
            $userId,
            $product['name'],
            $product['type-id'],
            $time,
            $time
        ]));

        $id = $this->db->pdo->lastInsertId();

        if(!empty($product['price']))
            $this->addPrice($id, $userId, $product['price']);
        if(!empty($product['rating']))
            $this->addRating($id, $userId, $product['rating']);
        if(!empty($product['picture']))
            $this->getPictureRepository()->addPicture($id, $product['picture'], $userId);

        $this->commit();

        return $id;
    }

    public function addPrice(int $productId, int $userId, int $price)
    {
        $time = time();

        $this->write(SimpleQuery::table('product_price')->insert([$productId, $userId, $price, $time, $time]));
    }

    public function addRating(int $productId, int $userId, int $rating)
    {
        $time = time();
        $this->write(
            SimpleQuery::table('product_rating')->insert([$productId, $userId, $rating, $time, $time])
        );
    }

    public function getProductsBasic(): array
    {
        return $this->read(new ProductListQuery());
    }

    public function getAvgPriceNumberOfRecords()
    {
        return $this->db->read(
            new Query('SELECT AVG(price) AS price, COUNT(*) AS number_of_records FROM product_price;')
        );
    }

    public function getProductFull(int $id, ?int $userId): array
    {
        $product = $this->db->read(new ProductFullQuery($id))[0];

        $pictureRepo = $this->getPictureRepository();
        $pictures = $pictureRepo->getPictures($id);
        $product['pictures'] = $pictures;
        $product['userRating'] = ($userId === null ? null : $this->getUserRating($userId, $id));
        $product['userPrice'] = ($userId === null ? null : $this->getUserPrice($userId, $id));
        if (!empty($pictures)) {
            $product['randomPicture'] = 
            $pictureRepo->getPicture($pictures[rand(0, count($pictures) - 1)]['id'], $userId);
        }

        return $product;
    }

    public function addType(string $name): int
    {
        $this->write(new Query('INSERT INTO product_type VALUES(null, :type);',
            ['type' => $name]
        ));

        return $this->db->pdo->lastInsertId();
    }

    public function getTypes(string $name): array
    {
        return $this->read(new Query('SELECT * FROM product_type WHERE name LIKE :type;',
            ['type' => "%{$name}%"]
        ));
    }

    public function updatePrice(int $userId, int $productId, int $price): void
    {
        $this->write(new Query(
            'UPDATE product_price SET price = :price WHERE user_id = :userId and product_id = :productId;',
            ['price' =>  $price, 'userId' => $userId, 'productId' => $productId]
        ));
    }

    public function updateRating(int $userId, int $productId, int $rating): void
    {
        $this->write(new Query(
            'UPDATE product_rating SET rating = :rating WHERE user_id = :userId and product_id = :productId;',
            ['rating' =>  $rating, 'userId' => $userId, 'productId' => $productId]
        ));
    }

    public function getUserPrice(int $userId, int $productId): ?int
    {
        $price = $this->read(SimpleQuery::table('product_price')->select(['price'], ['product_id' => $productId, 'user_id' => $userId]));

        return (empty($price) ? null : $price[0]['price']);
    }

    public function getUserRating(int $userId, int $productId): ?int
    {
        $rating = $this->read(SimpleQuery::table('product_rating')->select(['rating'], ['product_id' => $productId, 'user_id' => $userId]));

        return (empty($rating) ? null : $rating[0]['rating']);
    }
}
