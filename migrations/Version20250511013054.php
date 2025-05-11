<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511013054 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP zip_c
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice ADD issued_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', ADD due_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)', ADD status VARCHAR(255) DEFAULT NULL, ADD notes LONGTEXT DEFAULT NULL, ADD created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', ADD updated_at DATETIME DEFAULT NULL COMMENT '(DC2Type:datetime_immutable)'
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD zip_c VARCHAR(255) NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice DROP issued_at, DROP due_at, DROP status, DROP notes, DROP created_at, DROP updated_at
        SQL);
    }
}
