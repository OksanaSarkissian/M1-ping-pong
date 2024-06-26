<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240626092113 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poste_machine (poste_id INT NOT NULL, machine_id INT NOT NULL, PRIMARY KEY(poste_id, machine_id))');
        $this->addSql('CREATE INDEX IDX_65BFFD14A0905086 ON poste_machine (poste_id)');
        $this->addSql('CREATE INDEX IDX_65BFFD14F6B75B26 ON poste_machine (machine_id)');
        $this->addSql('ALTER TABLE poste_machine ADD CONSTRAINT FK_65BFFD14A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poste_machine ADD CONSTRAINT FK_65BFFD14F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE poste_machine DROP CONSTRAINT FK_65BFFD14A0905086');
        $this->addSql('ALTER TABLE poste_machine DROP CONSTRAINT FK_65BFFD14F6B75B26');
        $this->addSql('DROP TABLE poste_machine');
    }
}
