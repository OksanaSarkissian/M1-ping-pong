<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624070933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE gamme_operation (gamme_id INT NOT NULL, operation_id INT NOT NULL, PRIMARY KEY(gamme_id, operation_id))');
        $this->addSql('CREATE INDEX IDX_7608A5FBD2FD85F1 ON gamme_operation (gamme_id)');
        $this->addSql('CREATE INDEX IDX_7608A5FB44AC3583 ON gamme_operation (operation_id)');
        $this->addSql('ALTER TABLE gamme_operation ADD CONSTRAINT FK_7608A5FBD2FD85F1 FOREIGN KEY (gamme_id) REFERENCES gamme (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE gamme_operation ADD CONSTRAINT FK_7608A5FB44AC3583 FOREIGN KEY (operation_id) REFERENCES operation (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE gamme_operation DROP CONSTRAINT FK_7608A5FBD2FD85F1');
        $this->addSql('ALTER TABLE gamme_operation DROP CONSTRAINT FK_7608A5FB44AC3583');
        $this->addSql('DROP TABLE gamme_operation');
    }
}
