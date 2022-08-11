<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220712205511 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personel ADD departement_id INT NOT NULL, ADD personel_id INT NOT NULL, ADD type_perso_id INT NOT NULL');
        $this->addSql('ALTER TABLE personel ADD CONSTRAINT FK_95E6A880CCF9E01E FOREIGN KEY (departement_id) REFERENCES departement (id)');
        $this->addSql('ALTER TABLE personel ADD CONSTRAINT FK_95E6A880A8C3AF89 FOREIGN KEY (personel_id) REFERENCES personel (id)');
        $this->addSql('ALTER TABLE personel ADD CONSTRAINT FK_95E6A880DFDEC7E5 FOREIGN KEY (type_perso_id) REFERENCES type_perso (id)');
        $this->addSql('CREATE INDEX IDX_95E6A880CCF9E01E ON personel (departement_id)');
        $this->addSql('CREATE INDEX IDX_95E6A880A8C3AF89 ON personel (personel_id)');
        $this->addSql('CREATE INDEX IDX_95E6A880DFDEC7E5 ON personel (type_perso_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personel DROP FOREIGN KEY FK_95E6A880CCF9E01E');
        $this->addSql('ALTER TABLE personel DROP FOREIGN KEY FK_95E6A880A8C3AF89');
        $this->addSql('ALTER TABLE personel DROP FOREIGN KEY FK_95E6A880DFDEC7E5');
        $this->addSql('DROP INDEX IDX_95E6A880CCF9E01E ON personel');
        $this->addSql('DROP INDEX IDX_95E6A880A8C3AF89 ON personel');
        $this->addSql('DROP INDEX IDX_95E6A880DFDEC7E5 ON personel');
        $this->addSql('ALTER TABLE personel DROP departement_id, DROP personel_id, DROP type_perso_id');
    }
}
