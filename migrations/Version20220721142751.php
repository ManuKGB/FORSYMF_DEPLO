<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220721142751 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE actif actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE taches ADD projets_id INT NOT NULL');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98597A6CB7 FOREIGN KEY (projets_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD98597A6CB7 ON taches (projets_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE projet CHANGE actif actif TINYINT(1) DEFAULT 1 NOT NULL');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98597A6CB7');
        $this->addSql('DROP INDEX IDX_3BF2CD98597A6CB7 ON taches');
        $this->addSql('ALTER TABLE taches DROP projets_id');
    }
}
