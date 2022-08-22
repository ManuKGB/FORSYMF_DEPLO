<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220819115016 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP INDEX UNIQ_C1765B63150A48F1, ADD INDEX IDX_C1765B63150A48F1 (chef_id)');
        $this->addSql('ALTER TABLE personel ADD mdp_changed TINYINT(1) DEFAULT NULL, ADD name_changed TINYINT(1) DEFAULT NULL, ADD profile_image VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departement DROP INDEX IDX_C1765B63150A48F1, ADD UNIQUE INDEX UNIQ_C1765B63150A48F1 (chef_id)');
        $this->addSql('ALTER TABLE personel DROP mdp_changed, DROP name_changed, DROP profile_image');
    }
}
