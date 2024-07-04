<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704153101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE achat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fournisseur_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE ligne_achat_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE achat (id INT NOT NULL, fournisseur_id INT NOT NULL, date DATE NOT NULL, livraison_prevue DATE NOT NULL, livraison_reelle DATE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_26A98456670C757F ON achat (fournisseur_id)');
        $this->addSql('COMMENT ON COLUMN achat.date IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN achat.livraison_prevue IS \'(DC2Type:date_immutable)\'');
        $this->addSql('COMMENT ON COLUMN achat.livraison_reelle IS \'(DC2Type:date_immutable)\'');
        $this->addSql('CREATE TABLE fournisseur (id INT NOT NULL, raison_sociale VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE ligne_achat (id INT NOT NULL, piece_id INT NOT NULL, achat_id INT NOT NULL, prix_catalogue DOUBLE PRECISION NOT NULL, prix_achat DOUBLE PRECISION NOT NULL, quantite INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_25056E66C40FCFA8 ON ligne_achat (piece_id)');
        $this->addSql('CREATE INDEX IDX_25056E66FE95D117 ON ligne_achat (achat_id)');
        $this->addSql('ALTER TABLE achat ADD CONSTRAINT FK_26A98456670C757F FOREIGN KEY (fournisseur_id) REFERENCES fournisseur (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_achat ADD CONSTRAINT FK_25056E66C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_achat ADD CONSTRAINT FK_25056E66FE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE achat_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fournisseur_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE ligne_achat_id_seq CASCADE');
        $this->addSql('ALTER TABLE achat DROP CONSTRAINT FK_26A98456670C757F');
        $this->addSql('ALTER TABLE ligne_achat DROP CONSTRAINT FK_25056E66C40FCFA8');
        $this->addSql('ALTER TABLE ligne_achat DROP CONSTRAINT FK_25056E66FE95D117');
        $this->addSql('DROP TABLE achat');
        $this->addSql('DROP TABLE fournisseur');
        $this->addSql('DROP TABLE ligne_achat');
    }
}
