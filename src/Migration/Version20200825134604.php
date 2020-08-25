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
        $this->createUserTable();
    }

    public function down(Schema $schema) : void
    {
        $this->addSql(
            'DROP TABLE user;'
        );
    }

    private function createUserTable()
    {
        $this->addSql(
            'CREATE TABLE user(
                id bigint UNSIGNED PRIMARY KEY NOT NULL AUTO_INCREMENT,
                name varchar(255) NOT NULL UNIQUE,
                email varchar(255) NOT NULL UNIQUE,
                password varchar(512) NOT NULL
            );'
        );
    }
}
