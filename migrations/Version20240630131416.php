<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240630131416 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE client_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_document_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE client (id INT NOT NULL, raison_sociale VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE document (id INT NOT NULL, client_id INT NOT NULL, date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, type VARCHAR(255) NOT NULL, montant_total DOUBLE PRECISION NOT NULL, delai TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_D8698A7619EB6921 ON document (client_id)');
        $this->addSql('COMMENT ON COLUMN document.date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN document.delai IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE document_document (document_source INT NOT NULL, document_target INT NOT NULL, PRIMARY KEY(document_source, document_target))');
        $this->addSql('CREATE INDEX IDX_57A87B2FE1E8CE15 ON document_document (document_source)');
        $this->addSql('CREATE INDEX IDX_57A87B2FF80D9E9A ON document_document (document_target)');
        $this->addSql('CREATE TABLE document_ligne_document (document_id INT NOT NULL, ligne_document_id INT NOT NULL, PRIMARY KEY(document_id, ligne_document_id))');
        $this->addSql('CREATE INDEX IDX_FDBE6E4CC33F7837 ON document_ligne_document (document_id)');
        $this->addSql('CREATE INDEX IDX_FDBE6E4CA0DAB800 ON document_ligne_document (ligne_document_id)');
        $this->addSql('CREATE TABLE ligne_document (id INT NOT NULL, piece_id INT NOT NULL, quantite INT NOT NULL, prix_vente DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_87F39B40C40FCFA8 ON ligne_document (piece_id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A7619EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_document ADD CONSTRAINT FK_57A87B2FE1E8CE15 FOREIGN KEY (document_source) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_document ADD CONSTRAINT FK_57A87B2FF80D9E9A FOREIGN KEY (document_target) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_ligne_document ADD CONSTRAINT FK_FDBE6E4CC33F7837 FOREIGN KEY (document_id) REFERENCES document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE document_ligne_document ADD CONSTRAINT FK_FDBE6E4CA0DAB800 FOREIGN KEY (ligne_document_id) REFERENCES ligne_document (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_document ADD CONSTRAINT FK_87F39B40C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE client_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE document_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_document_id_seq CASCADE');
        $this->addSql('ALTER TABLE document DROP CONSTRAINT FK_D8698A7619EB6921');
        $this->addSql('ALTER TABLE document_document DROP CONSTRAINT FK_57A87B2FE1E8CE15');
        $this->addSql('ALTER TABLE document_document DROP CONSTRAINT FK_57A87B2FF80D9E9A');
        $this->addSql('ALTER TABLE document_ligne_document DROP CONSTRAINT FK_FDBE6E4CC33F7837');
        $this->addSql('ALTER TABLE document_ligne_document DROP CONSTRAINT FK_FDBE6E4CA0DAB800');
        $this->addSql('ALTER TABLE ligne_document DROP CONSTRAINT FK_87F39B40C40FCFA8');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_document');
        $this->addSql('DROP TABLE document_ligne_document');
        $this->addSql('DROP TABLE ligne_document');
    }
}
