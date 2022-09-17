<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220806092220 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personel DROP FOREIGN KEY FK_95E6A880727ACA70');
        $this->addSql('DROP INDEX UNIQ_95E6A880727ACA70 ON personel');
        $this->addSql('ALTER TABLE personel DROP parent_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE personel ADD parent_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE personel ADD CONSTRAINT FK_95E6A880727ACA70 FOREIGN KEY (parent_id) REFERENCES departement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_95E6A880727ACA70 ON personel (parent_id)');
    }
}
