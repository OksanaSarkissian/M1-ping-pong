<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240704191845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE achat_ligne_achat (achat_id INT NOT NULL, ligne_achat_id INT NOT NULL, PRIMARY KEY(achat_id, ligne_achat_id))');
        $this->addSql('CREATE INDEX IDX_CB60BF5BFE95D117 ON achat_ligne_achat (achat_id)');
        $this->addSql('CREATE INDEX IDX_CB60BF5BA10FC021 ON achat_ligne_achat (ligne_achat_id)');
        $this->addSql('ALTER TABLE achat_ligne_achat ADD CONSTRAINT FK_CB60BF5BFE95D117 FOREIGN KEY (achat_id) REFERENCES achat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE achat_ligne_achat ADD CONSTRAINT FK_CB60BF5BA10FC021 FOREIGN KEY (ligne_achat_id) REFERENCES ligne_achat (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE ligne_achat DROP CONSTRAINT fk_25056e66fe95d117');
        $this->addSql('DROP INDEX idx_25056e66fe95d117');
        $this->addSql('ALTER TABLE ligne_achat DROP achat_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE achat_ligne_achat DROP CONSTRAINT FK_CB60BF5BFE95D117');
        $this->addSql('ALTER TABLE achat_ligne_achat DROP CONSTRAINT FK_CB60BF5BA10FC021');
        $this->addSql('DROP TABLE achat_ligne_achat');
        $this->addSql('ALTER TABLE ligne_achat ADD achat_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ligne_achat ADD CONSTRAINT fk_25056e66fe95d117 FOREIGN KEY (achat_id) REFERENCES achat (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_25056e66fe95d117 ON ligne_achat (achat_id)');
    }
}
