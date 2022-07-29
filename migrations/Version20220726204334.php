<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220726204334 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CACF6010CA');
        $this->addSql('DROP INDEX IDX_BF5476CACF6010CA ON notification');
        $this->addSql('ALTER TABLE notification CHANGE mig_tache_id tache_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CAD2235D39 FOREIGN KEY (tache_id) REFERENCES taches (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CAD2235D39 ON notification (tache_id)');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98597A6CB7');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD9824686299');
        $this->addSql('DROP INDEX IDX_3BF2CD98597A6CB7 ON taches');
        $this->addSql('DROP INDEX IDX_3BF2CD9824686299 ON taches');
        $this->addSql('ALTER TABLE taches ADD projet_id INT DEFAULT NULL, DROP projets_id, DROP mig_projet_id');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98C18272 FOREIGN KEY (projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD98C18272 ON taches (projet_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE notification DROP FOREIGN KEY FK_BF5476CAD2235D39');
        $this->addSql('DROP INDEX IDX_BF5476CAD2235D39 ON notification');
        $this->addSql('ALTER TABLE notification CHANGE tache_id mig_tache_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE notification ADD CONSTRAINT FK_BF5476CACF6010CA FOREIGN KEY (mig_tache_id) REFERENCES taches (id)');
        $this->addSql('CREATE INDEX IDX_BF5476CACF6010CA ON notification (mig_tache_id)');
        $this->addSql('ALTER TABLE taches DROP FOREIGN KEY FK_3BF2CD98C18272');
        $this->addSql('DROP INDEX IDX_3BF2CD98C18272 ON taches');
        $this->addSql('ALTER TABLE taches ADD mig_projet_id INT DEFAULT NULL, CHANGE projet_id projets_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD98597A6CB7 FOREIGN KEY (projets_id) REFERENCES projet (id)');
        $this->addSql('ALTER TABLE taches ADD CONSTRAINT FK_3BF2CD9824686299 FOREIGN KEY (mig_projet_id) REFERENCES projet (id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD98597A6CB7 ON taches (projets_id)');
        $this->addSql('CREATE INDEX IDX_3BF2CD9824686299 ON taches (mig_projet_id)');
    }
}
