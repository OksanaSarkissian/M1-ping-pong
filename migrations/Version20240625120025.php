<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625120025 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gamme DROP CONSTRAINT fk_c32e1468c40fcfa8');
        $this->addSql('DROP INDEX uniq_c32e1468c40fcfa8');
        $this->addSql('ALTER TABLE gamme DROP piece_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gamme ADD piece_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT fk_c32e1468c40fcfa8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_c32e1468c40fcfa8 ON gamme (piece_id)');
    }
}
