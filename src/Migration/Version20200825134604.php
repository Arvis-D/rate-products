<?php

declare(strict_types=1);

namespace App\Migration;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200825134604 extends AbstractMigration
{
    private $tables = [];

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('SET foreign_key_checks = 0');
        $this->createUserTable();
        $this->createProductsTable();
        $this->createProductPriceTable();

        $this->createLikeTable('product_picture');
        $this->createRatingTable('product');
        $this->createCommentTable('product');
        $this->createPictureTable('product');

        $this->addSql('SET foreign_key_checks = 1');
    }

    public function down(Schema $schema) : void
    {
        $tables = implode(',', $this->tables);

        $this->addSql(
            "SET foreign_key_checks = 0;
            DROP TABLE IF EXISTS
            {$tables}
            ;
            SET foreign_key_checks = 1;"
        );
    }

    private function createUserTable()
    {
        $this->addSql(
            'CREATE TABLE user(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL UNIQUE,
                email varchar(255) NOT NULL UNIQUE,
                password varchar(512) NOT NULL,
                avatar_url varchar(512),
                time_added int UNSIGNED NOT NULL,
                time_last_active int UNSIGNED NOT NULL
            );'
        );

        array_push($this->tables, "user");
    }

    private function createProductsTable()
    {
        $this->addSql(
            'CREATE TABLE product(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                user_id int UNSIGNED NOT NULL,
                name varchar(255) NOT NULL UNIQUE,
                time_created int UNSIGNED NOT NULL,
                time_changed int UNSIGNED NOT NULL,

                FOREIGN KEY (user_id) REFERENCES user(id)
            );'
        );

        array_push($this->tables, "product");
    }

    private function createProductPriceTable()
    {
        $this->addSql(
            'CREATE TABLE product_price(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                product_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                price int UNSIGNED NOT NULL,
                time_created int UNSIGNED NOT NULL,
                time_changed int UNSIGNED NOT NULL,

                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            );'
        );

        array_push($this->tables, "product_price");
    }

    private function createRatingTable(string $subject)
    {
        $this->addSql(
            'CREATE TABLE product_rating(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                product_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                rating tinyint UNSIGNED NOT NULL,
                time_created int UNSIGNED NOT NULL,
                time_changed int UNSIGNED NOT NULL,

                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
            );'
        );

        array_push($this->tables, "{$subject}_like");
    }

    private function createPictureTable(string $subject)
    {
        $this->addSql(
            "CREATE TABLE {$subject}_picture(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                {$subject}_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                url text NOT NULL,
                time_created int UNSIGNED NOT NULL,

                FOREIGN KEY ({$subject}_id) REFERENCES {$subject}(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            );"
        );

        array_push($this->tables, "{$subject}_like");
    }

    private function createCommentTable(string $subject)
    {
        $this->addSql(
            "CREATE TABLE {$subject}_comment(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                {$subject}_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                content text NOT NULL,
                time_created int UNSIGNED NOT NULL,
                time_changed int UNSIGNED NOT NULL,

                FOREIGN KEY ({$subject}_id) REFERENCES {$subject}(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            );"
        );

        array_push($this->tables, "{$subject}_like");
    }

    private function createLikeTable(string $subject)
    {
        $this->addSql(
            "CREATE TABLE {$subject}_like(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                {$subject}_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                like_or_dislike tinyint NOT NULL,

                FOREIGN KEY ({$subject}_id) REFERENCES {$subject}(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
            );"
        );

        array_push($this->tables, "{$subject}_like");
    }
}
