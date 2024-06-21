<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621093021 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE gamme_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE machine_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE operation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE piece_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE poste_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE realisation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "user_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE gamme (id INT NOT NULL, responsable_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C32E146853C59D72 ON gamme (responsable_id)');
        $this->addSql('CREATE TABLE machine (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE machine_poste (machine_id INT NOT NULL, poste_id INT NOT NULL, PRIMARY KEY(machine_id, poste_id))');
        $this->addSql('CREATE INDEX IDX_5506CCD8F6B75B26 ON machine_poste (machine_id)');
        $this->addSql('CREATE INDEX IDX_5506CCD8A0905086 ON machine_poste (poste_id)');
        $this->addSql('CREATE TABLE operation (id INT NOT NULL, poste_id_id INT NOT NULL, machine_id_id INT NOT NULL, libelle VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, temps TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_1981A66DC94D6CB2 ON operation (poste_id_id)');
        $this->addSql('CREATE INDEX IDX_1981A66D56CB5D24 ON operation (machine_id_id)');
        $this->addSql('CREATE TABLE piece (id INT NOT NULL, gamme_id_id INT NOT NULL, reference_piece VARCHAR(255) NOT NULL, libelle_piece VARCHAR(255) NOT NULL, prix_u DOUBLE PRECISION NOT NULL, stock INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_44CA0B2357BF3EAA ON piece (gamme_id_id)');
        $this->addSql('CREATE TABLE poste (id INT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE poste_user (poste_id INT NOT NULL, user_id INT NOT NULL, PRIMARY KEY(poste_id, user_id))');
        $this->addSql('CREATE INDEX IDX_E24C0E76A0905086 ON poste_user (poste_id)');
        $this->addSql('CREATE INDEX IDX_E24C0E76A76ED395 ON poste_user (user_id)');
        $this->addSql('CREATE TABLE realisation (id INT NOT NULL, poste_id_reel_id INT NOT NULL, machine_id_reel_id INT NOT NULL, piece_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, temps_reel TIME(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_EAA5610EA8082173 ON realisation (poste_id_reel_id)');
        $this->addSql('CREATE INDEX IDX_EAA5610EADB89DE0 ON realisation (machine_id_reel_id)');
        $this->addSql('CREATE INDEX IDX_EAA5610EC40FCFA8 ON realisation (piece_id)');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, identifiant VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E146853C59D72 FOREIGN KEY (responsable_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE machine_poste ADD CONSTRAINT FK_5506CCD8F6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE machine_poste ADD CONSTRAINT FK_5506CCD8A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DC94D6CB2 FOREIGN KEY (poste_id_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66D56CB5D24 FOREIGN KEY (machine_id_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B2357BF3EAA FOREIGN KEY (gamme_id_id) REFERENCES gamme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poste_user ADD CONSTRAINT FK_E24C0E76A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE poste_user ADD CONSTRAINT FK_E24C0E76A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EA8082173 FOREIGN KEY (poste_id_reel_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EADB89DE0 FOREIGN KEY (machine_id_reel_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610EC40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE gamme_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE machine_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE operation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE piece_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE poste_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE realisation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "user_id_seq" CASCADE');
        $this->addSql('ALTER TABLE gamme DROP CONSTRAINT FK_C32E146853C59D72');
        $this->addSql('ALTER TABLE machine_poste DROP CONSTRAINT FK_5506CCD8F6B75B26');
        $this->addSql('ALTER TABLE machine_poste DROP CONSTRAINT FK_5506CCD8A0905086');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT FK_1981A66DC94D6CB2');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT FK_1981A66D56CB5D24');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT FK_44CA0B2357BF3EAA');
        $this->addSql('ALTER TABLE poste_user DROP CONSTRAINT FK_E24C0E76A0905086');
        $this->addSql('ALTER TABLE poste_user DROP CONSTRAINT FK_E24C0E76A76ED395');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610EA8082173');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610EADB89DE0');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610EC40FCFA8');
        $this->addSql('DROP TABLE gamme');
        $this->addSql('DROP TABLE machine');
        $this->addSql('DROP TABLE machine_poste');
        $this->addSql('DROP TABLE operation');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE poste_user');
        $this->addSql('DROP TABLE realisation');
        $this->addSql('DROP TABLE "user"');
    }
}
