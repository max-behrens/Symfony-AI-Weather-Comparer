<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250208120003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // This will be automatically generated based on your entity changes
        $this->addSql('ALTER TABLE calculations DROP COLUMN calculation');
        $this->addSql('ALTER TABLE calculations DROP COLUMN due_date');
        $this->addSql('ALTER TABLE calculations ADD calculations TEXT NOT NULL');
        $this->addSql('ALTER TABLE calculations ADD ai_response TEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // This will also be automatically generated
        $this->addSql('ALTER TABLE calculations ADD calculation VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE calculations ADD due_date DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE calculations DROP calculations');
        $this->addSql('ALTER TABLE calculations DROP ai_response');
    }
}
