<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628064155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation ADD operation_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EAA5610E44AC3583 ON realisation (operation_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610E44AC3583');
        $this->addSql('DROP INDEX IDX_EAA5610E44AC3583');
        $this->addSql('ALTER TABLE realisation DROP operation_id');
    }
}
