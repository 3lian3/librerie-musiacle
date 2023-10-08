<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231005200703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE album_style (album_id INT NOT NULL, style_id INT NOT NULL, INDEX IDX_4505F24C1137ABCF (album_id), INDEX IDX_4505F24CBACD6074 (style_id), PRIMARY KEY(album_id, style_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE album_style ADD CONSTRAINT FK_4505F24C1137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_style ADD CONSTRAINT FK_4505F24CBACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B81137ABCF');
        $this->addSql('ALTER TABLE style_album DROP FOREIGN KEY FK_F34D20B8BACD6074');
        $this->addSql('DROP TABLE style_album');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('CREATE TABLE style_album (style_id INT NOT NULL, album_id INT NOT NULL, INDEX IDX_F34D20B8BACD6074 (style_id), INDEX IDX_F34D20B81137ABCF (album_id), PRIMARY KEY(style_id, album_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B81137ABCF FOREIGN KEY (album_id) REFERENCES album (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE style_album ADD CONSTRAINT FK_F34D20B8BACD6074 FOREIGN KEY (style_id) REFERENCES style (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE album_style DROP FOREIGN KEY FK_4505F24C1137ABCF');
        $this->addSql('ALTER TABLE album_style DROP FOREIGN KEY FK_4505F24CBACD6074');
        $this->addSql('DROP TABLE album_style');
        $this->addSql('DROP TABLE user');
    }
}
