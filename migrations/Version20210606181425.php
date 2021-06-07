<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210606181425 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarifs DROP INDEX UNIQ_F9B8C4964A4A3511, ADD INDEX IDX_F9B8C4964A4A3511 (vehicule_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tarifs DROP INDEX IDX_F9B8C4964A4A3511, ADD UNIQUE INDEX UNIQ_F9B8C4964A4A3511 (vehicule_id)');
    }
}
