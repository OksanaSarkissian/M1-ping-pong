<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240628131113 extends AbstractMigration
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
        $this->addSql('ALTER TABLE poste_user DROP CONSTRAINT fk_e24c0e76a0905086');
        $this->addSql('ALTER TABLE poste_user DROP CONSTRAINT fk_e24c0e76a76ed395');
        $this->addSql('DROP TABLE poste_user');
        $this->addSql('ALTER TABLE machine_poste DROP CONSTRAINT machine_poste_pkey');
        $this->addSql('ALTER TABLE machine_poste ADD PRIMARY KEY (machine_id, poste_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE poste_user (poste_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(poste_id, user_id))');
        $this->addSql('CREATE INDEX idx_e24c0e76a76ed395 ON poste_user (user_id)');
        $this->addSql('CREATE INDEX idx_e24c0e76a0905086 ON poste_user (poste_id)');
        $this->addSql('ALTER TABLE poste_user ADD CONSTRAINT fk_e24c0e76a0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poste_user ADD CONSTRAINT fk_e24c0e76a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE user_poste DROP CONSTRAINT FK_9E4BF4F3A76ED395');
        $this->addSql('ALTER TABLE user_poste DROP CONSTRAINT FK_9E4BF4F3A0905086');
        $this->addSql('DROP TABLE user_poste');
        $this->addSql('DROP INDEX machine_poste_pkey');
        $this->addSql('ALTER TABLE machine_poste ADD PRIMARY KEY (poste_id, machine_id)');
    }
}
