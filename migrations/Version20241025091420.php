<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241025091420 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajoutez la colonne weight qui permet NULL
        $this->addSql('ALTER TABLE pokemon ADD weight INT DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon ADD back_default VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon RENAME COLUMN image_url TO front_default');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pokemon ADD image_url VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE pokemon DROP weight');
        $this->addSql('ALTER TABLE pokemon DROP front_default');
        $this->addSql('ALTER TABLE pokemon DROP back_default');
    }
}
