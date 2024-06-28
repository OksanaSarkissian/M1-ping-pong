<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628075100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT fk_eaa5610ec40fcfa8');
        $this->addSql('DROP INDEX idx_eaa5610ec40fcfa8');
        $this->addSql('ALTER TABLE realisation DROP piece_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE realisation ADD piece_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT fk_eaa5610ec40fcfa8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eaa5610ec40fcfa8 ON realisation (piece_id)');
    }
}
