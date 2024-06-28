<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628130601 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_poste (user_id INT NOT NULL, poste_id INT NOT NULL, PRIMARY KEY(user_id, poste_id))');
        $this->addSql('CREATE INDEX IDX_9E4BF4F3A76ED395 ON user_poste (user_id)');
        $this->addSql('CREATE INDEX IDX_9E4BF4F3A0905086 ON user_poste (poste_id)');
        $this->addSql('ALTER TABLE user_poste ADD CONSTRAINT FK_9E4BF4F3A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_poste ADD CONSTRAINT FK_9E4BF4F3A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE user_poste DROP CONSTRAINT FK_9E4BF4F3A76ED395');
        $this->addSql('ALTER TABLE user_poste DROP CONSTRAINT FK_9E4BF4F3A0905086');
        $this->addSql('DROP TABLE user_poste');
    }
}
