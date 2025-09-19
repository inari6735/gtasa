<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250918235004 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE media CHANGE mime_type mime_type VARCHAR(100) NOT NULL');
        $this->addSql('ALTER TABLE upload_session CHANGE mime_type mime_type VARCHAR(100) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE upload_session CHANGE mime_type mime_type VARCHAR(20) NOT NULL');
        $this->addSql('ALTER TABLE media CHANGE mime_type mime_type VARCHAR(20) NOT NULL');
    }
}
