<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250511011208 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer ADD email VARCHAR(255) NOT NULL, ADD phone_number VARCHAR(50) DEFAULT NULL, ADD adress VARCHAR(255) NOT NULL, ADD complement_adress VARCHAR(255) DEFAULT NULL, ADD zip_c VARCHAR(255) NOT NULL, ADD zip VARCHAR(50) NOT NULL, ADD city VARCHAR(255) NOT NULL, ADD notes LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE customer DROP email, DROP phone_number, DROP adress, DROP complement_adress, DROP zip_c, DROP zip, DROP city, DROP notes
        SQL);
    }
}
