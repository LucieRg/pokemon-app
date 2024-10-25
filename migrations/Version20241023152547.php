<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241023152547 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pokemon ADD height INT NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD weight INT NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD types JSON NOT NULL');
        $this->addSql('ALTER TABLE pokemon ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon DROP image');
        $this->addSql('ALTER TABLE pokemon DROP type');
        $this->addSql('ALTER TABLE pokemon DROP stats');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pokemon ADD type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD stats VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE pokemon DROP height');
        $this->addSql('ALTER TABLE pokemon DROP weight');
        $this->addSql('ALTER TABLE pokemon DROP types');
        $this->addSql('ALTER TABLE pokemon RENAME COLUMN image_url TO image');
    }
}
