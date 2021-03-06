<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211029072358 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE thematic ADD owner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE thematic ADD CONSTRAINT FK_7C1CDF727E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_7C1CDF727E3C61F9 ON thematic (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE movie DROP run_time, DROP actors');
        $this->addSql('ALTER TABLE thematic DROP FOREIGN KEY FK_7C1CDF727E3C61F9');
        $this->addSql('DROP INDEX IDX_7C1CDF727E3C61F9 ON thematic');
        $this->addSql('ALTER TABLE thematic DROP owner_id');
    }
}
