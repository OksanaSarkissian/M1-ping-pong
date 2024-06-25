<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625115658 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE gamme ADD piece_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE gamme ADD CONSTRAINT FK_C32E1468C40FCFA8 FOREIGN KEY (piece_id) REFERENCES piece (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C32E1468C40FCFA8 ON gamme (piece_id)');
        $this->addSql('ALTER TABLE piece DROP CONSTRAINT fk_44ca0b23d2fd85f1');
        $this->addSql('DROP INDEX uniq_44ca0b23d2fd85f1');
        $this->addSql('ALTER TABLE piece DROP gamme_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE piece ADD gamme_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT fk_44ca0b23d2fd85f1 FOREIGN KEY (gamme_id) REFERENCES gamme (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_44ca0b23d2fd85f1 ON piece (gamme_id)');
        $this->addSql('ALTER TABLE gamme DROP CONSTRAINT FK_C32E1468C40FCFA8');
        $this->addSql('DROP INDEX UNIQ_C32E1468C40FCFA8');
        $this->addSql('ALTER TABLE gamme DROP piece_id');
    }
}
