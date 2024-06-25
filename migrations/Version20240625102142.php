<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625102142 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gamme ADD piece_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C32E1468C40FCFA8 ON gamme (piece_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gamme DROP CONSTRAINT FK_C32E1468C40FCFA8');
        $this->addSql('DROP INDEX UNIQ_C32E1468C40FCFA8');
        $this->addSql('ALTER TABLE gamme DROP piece_id');
    }
}
