<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240625141439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT fk_eaa5610ea8082173');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT fk_eaa5610eadb89de0');
        $this->addSql('DROP INDEX idx_eaa5610eadb89de0');
        $this->addSql('DROP INDEX idx_eaa5610ea8082173');
        $this->addSql('ALTER TABLE realisation ADD poste_reel_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD machine_reel_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation DROP poste_id_reel_id');
        $this->addSql('ALTER TABLE realisation DROP machine_id_reel_id');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E773A0EA1 FOREIGN KEY (poste_reel_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT FK_EAA5610E1FFBC81 FOREIGN KEY (machine_reel_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_EAA5610E773A0EA1 ON realisation (poste_reel_id)');
        $this->addSql('CREATE INDEX IDX_EAA5610E1FFBC81 ON realisation (machine_reel_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610E773A0EA1');
        $this->addSql('ALTER TABLE realisation DROP CONSTRAINT FK_EAA5610E1FFBC81');
        $this->addSql('DROP INDEX IDX_EAA5610E773A0EA1');
        $this->addSql('DROP INDEX IDX_EAA5610E1FFBC81');
        $this->addSql('ALTER TABLE realisation ADD poste_id_reel_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation ADD machine_id_reel_id INT NOT NULL');
        $this->addSql('ALTER TABLE realisation DROP poste_reel_id');
        $this->addSql('ALTER TABLE realisation DROP machine_reel_id');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT fk_eaa5610ea8082173 FOREIGN KEY (poste_id_reel_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE realisation ADD CONSTRAINT fk_eaa5610eadb89de0 FOREIGN KEY (machine_id_reel_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_eaa5610eadb89de0 ON realisation (machine_id_reel_id)');
        $this->addSql('CREATE INDEX idx_eaa5610ea8082173 ON realisation (poste_id_reel_id)');
    }
}
