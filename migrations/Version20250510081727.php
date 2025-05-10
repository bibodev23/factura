<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250510081727 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice DROP FOREIGN KEY FK_906517449395C3F3
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_906517449395C3F3 ON invoice
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice DROP customer_id, DROP total
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice_line DROP FOREIGN KEY FK_D3D1D6932989F1FD
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_D3D1D6932989F1FD ON invoice_line
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice_line DROP invoice_id, DROP unit_price, DROP quantity
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice ADD customer_id INT NOT NULL, ADD total DOUBLE PRECISION DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice ADD CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_906517449395C3F3 ON invoice (customer_id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice_line ADD invoice_id INT NOT NULL, ADD unit_price DOUBLE PRECISION NOT NULL, ADD quantity INT NOT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE invoice_line ADD CONSTRAINT FK_D3D1D6932989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_D3D1D6932989F1FD ON invoice_line (invoice_id)
        SQL);
    }
}
