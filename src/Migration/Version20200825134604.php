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
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql('SET foreign_key_checks = 0');
        $this->createUserTable();

        $this->createProductsTable();
        $this->createProductRatingTable();
        $this->createProductCommentsTable();
        $this->createProductPicturesTable();
        $this->createProductCommentLikesTable();
        $this->createProductPriceTable();
        $this->createProductPictureLikesTable();

        $this->addSql('SET foreign_key_checks = 1');
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(
            'SET foreign_key_checks = 0;
            DROP TABLE IF EXISTS
            user,
            product,
            product_comment,
            product_picture,
            product_comment_like,
            product_picture_like,
            product_price,
            product_rating
            ;
            SET foreign_key_checks = 1;'
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
                time_added int UNSIGNED NOT NULL,
                time_last_active int UNSIGNED NOT NULL
            );'
        );
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
    }

    private function createProductRatingTable()
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
    }

    private function createProductPicturesTable()
    {
        $this->addSql(
            'CREATE TABLE product_picture(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                product_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                url text NOT NULL,
                time_created int UNSIGNED NOT NULL,

                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            );'
        );
    }

    private function createProductCommentsTable()
    {
        $this->addSql(
            'CREATE TABLE product_comment(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                product_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                content text NOT NULL,
                time_created int UNSIGNED NOT NULL,
                time_changed int UNSIGNED NOT NULL,

                FOREIGN KEY (product_id) REFERENCES product(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id)
            );'
        );
    }

    private function createProductCommentLikesTable()
    {
        $this->addSql(
            'CREATE TABLE product_comment_like(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                comment_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                like_or_dislike tinyint NOT NULL,

                FOREIGN KEY (comment_id) REFERENCES product_comment(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
            );'
        );
    }

    private function createProductPictureLikesTable()
    {
        $this->addSql(
            'CREATE TABLE product_picture_like(
                id int UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                picture_id int UNSIGNED NOT NULL,
                user_id int UNSIGNED NOT NULL,
                like_or_dislike tinyint NOT NULL,

                FOREIGN KEY (picture_id) REFERENCES product_picture(id) ON DELETE CASCADE,
                FOREIGN KEY (user_id) REFERENCES user(id) ON DELETE CASCADE
            );'
        );
    }
}
