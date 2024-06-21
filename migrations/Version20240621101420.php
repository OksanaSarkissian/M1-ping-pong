<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240621101420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE piece_piece (piece_source INT NOT NULL, piece_target INT NOT NULL, PRIMARY KEY(piece_source, piece_target))');
        $this->addSql('CREATE INDEX IDX_56798A4885F87422 ON piece_piece (piece_source)');
        $this->addSql('CREATE INDEX IDX_56798A489C1D24AD ON piece_piece (piece_target)');
        $this->addSql('ALTER TABLE piece_piece ADD CONSTRAINT FK_56798A4885F87422 FOREIGN KEY (piece_source) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece_piece ADD CONSTRAINT FK_56798A489C1D24AD FOREIGN KEY (piece_target) REFERENCES piece (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT fk_44ca0b2357bf3eaa');
        $this->addSql('DROP INDEX uniq_44ca0b2357bf3eaa');
        $this->addSql('ALTER TABLE piece ADD ref_piece VARCHAR(30) NOT NULL');
        $this->addSql('ALTER TABLE piece ADD prix_unitaire DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE piece DROP gamme_id_id');
        $this->addSql('ALTER TABLE piece DROP prix_u');
        $this->addSql('ALTER TABLE piece ALTER libelle_piece TYPE VARCHAR(100)');
        $this->addSql('ALTER TABLE piece RENAME COLUMN reference_piece TO type');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE piece_piece DROP CONSTRAINT FK_56798A4885F87422');
        $this->addSql('ALTER TABLE piece_piece DROP CONSTRAINT FK_56798A489C1D24AD');
        $this->addSql('DROP TABLE piece_piece');
        $this->addSql('ALTER TABLE piece ADD gamme_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE piece ADD prix_u DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE piece DROP ref_piece');
        $this->addSql('ALTER TABLE piece DROP prix_unitaire');
        $this->addSql('ALTER TABLE piece ALTER libelle_piece TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE piece RENAME COLUMN type TO reference_piece');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT fk_44ca0b2357bf3eaa FOREIGN KEY (gamme_id_id) REFERENCES gamme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_44ca0b2357bf3eaa ON piece (gamme_id_id)');
    }
}
