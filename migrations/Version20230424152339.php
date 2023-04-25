<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230424152339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE borrowing (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, manga_id INT NOT NULL, borrowing_date DATETIME NOT NULL, return_date DATETIME NOT NULL, is_returned TINYINT(1) NOT NULL, INDEX IDX_226E5897A76ED395 (user_id), INDEX IDX_226E58977B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE manga (id INT AUTO_INCREMENT NOT NULL, serie_id INT NOT NULL, volume_number INT NOT NULL, title VARCHAR(255) DEFAULT NULL, summary LONGTEXT NOT NULL, price DOUBLE PRECISION NOT NULL, edited_at DATE NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_765A9E03D94388BD (serie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE purchase (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, manga_id INT NOT NULL, purchase_date DATETIME NOT NULL, INDEX IDX_6117D13BA76ED395 (user_id), INDEX IDX_6117D13B7B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE serie (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, name VARCHAR(255) NOT NULL, original_name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_AA3A933412469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, manga_id INT NOT NULL, quantity INT NOT NULL, UNIQUE INDEX UNIQ_4B3656607B6461 (manga_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E5897A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE borrowing ADD CONSTRAINT FK_226E58977B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('ALTER TABLE manga ADD CONSTRAINT FK_765A9E03D94388BD FOREIGN KEY (serie_id) REFERENCES serie (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B7B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
        $this->addSql('ALTER TABLE serie ADD CONSTRAINT FK_AA3A933412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE stock ADD CONSTRAINT FK_4B3656607B6461 FOREIGN KEY (manga_id) REFERENCES manga (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E5897A76ED395');
        $this->addSql('ALTER TABLE borrowing DROP FOREIGN KEY FK_226E58977B6461');
        $this->addSql('ALTER TABLE manga DROP FOREIGN KEY FK_765A9E03D94388BD');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13BA76ED395');
        $this->addSql('ALTER TABLE purchase DROP FOREIGN KEY FK_6117D13B7B6461');
        $this->addSql('ALTER TABLE serie DROP FOREIGN KEY FK_AA3A933412469DE2');
        $this->addSql('ALTER TABLE stock DROP FOREIGN KEY FK_4B3656607B6461');
        $this->addSql('DROP TABLE borrowing');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE manga');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE serie');
        $this->addSql('DROP TABLE stock');
    }
}
