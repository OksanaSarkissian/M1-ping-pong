<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240619133428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, droit_id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, identifiant VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_8D93D6495AA93370 ON "user" (droit_id)');
        $this->addSql('ALTER TABLE "user" ADD CONSTRAINT FK_8D93D6495AA93370 FOREIGN KEY (droit_id) REFERENCES droit (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E146853C59D72 FOREIGN KEY (responsable_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_piece DROP "Qtt"');
        $this->addSql('ALTER TABLE poste_user ADD CONSTRAINT FK_E24C0E76A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gamme DROP CONSTRAINT FK_C32E146853C59D72');
        $this->addSql('ALTER TABLE poste_user DROP CONSTRAINT FK_E24C0E76A76ED395');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D6495AA93370');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('ALTER TABLE piece_piece ADD "Qtt" INT NOT NULL');
    }
}
