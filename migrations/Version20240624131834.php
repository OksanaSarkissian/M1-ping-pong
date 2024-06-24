<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240624131834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT fk_1981a66dc94d6cb2');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT fk_1981a66d56cb5d24');
        $this->addSql('DROP INDEX idx_1981a66d56cb5d24');
        $this->addSql('DROP INDEX idx_1981a66dc94d6cb2');
        $this->addSql('ALTER TABLE operation ADD poste_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation ADD machine_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation DROP poste_id_id');
        $this->addSql('ALTER TABLE operation DROP machine_id_id');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DA0905086 FOREIGN KEY (poste_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT FK_1981A66DF6B75B26 FOREIGN KEY (machine_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_1981A66DA0905086 ON operation (poste_id)');
        $this->addSql('CREATE INDEX IDX_1981A66DF6B75B26 ON operation (machine_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT FK_1981A66DA0905086');
        $this->addSql('ALTER TABLE operation DROP CONSTRAINT FK_1981A66DF6B75B26');
        $this->addSql('DROP INDEX IDX_1981A66DA0905086');
        $this->addSql('DROP INDEX IDX_1981A66DF6B75B26');
        $this->addSql('ALTER TABLE operation ADD poste_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation ADD machine_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE operation DROP poste_id');
        $this->addSql('ALTER TABLE operation DROP machine_id');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT fk_1981a66dc94d6cb2 FOREIGN KEY (poste_id_id) REFERENCES poste (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE operation ADD CONSTRAINT fk_1981a66d56cb5d24 FOREIGN KEY (machine_id_id) REFERENCES machine (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX idx_1981a66d56cb5d24 ON operation (machine_id_id)');
        $this->addSql('CREATE INDEX idx_1981a66dc94d6cb2 ON operation (poste_id_id)');
    }
}
