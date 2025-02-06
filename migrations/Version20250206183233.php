<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250206183233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    // src/Migrations/VersionXXXXXX.php
public function up(Schema $schema): void
{
    $this->addSql('CREATE TABLE calculations (id INT AUTO_INCREMENT NOT NULL, calculation VARCHAR(255) NOT NULL, due_date DATETIME DEFAULT NULL, PRIMARY KEY(id))');
}

public function down(Schema $schema): void
{
    $this->addSql('DROP TABLE calculations');
}

}
