<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230927145514 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE artiste CHANGE id id INT NOT NULL, CHANGE description description LONGTEXT NOT NULL, CHANGE site site VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE morceau CHANGE id id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE album CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE artiste CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE description description TEXT NOT NULL, CHANGE site site VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE morceau CHANGE id id INT AUTO_INCREMENT NOT NULL');
    }
}
