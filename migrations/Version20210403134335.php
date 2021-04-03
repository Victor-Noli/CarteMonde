<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210403134335 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE continents (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, region VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C966C8121CE9 (nom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE jwt (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, nom_id INT NOT NULL, INDEX IDX_A26779F3C8121CE9 (nom_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE country ADD CONSTRAINT FK_5373C966C8121CE9 FOREIGN KEY (nom_id) REFERENCES continents (id)');
        $this->addSql('ALTER TABLE regions ADD CONSTRAINT FK_A26779F3C8121CE9 FOREIGN KEY (nom_id) REFERENCES country (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP FOREIGN KEY FK_5373C966C8121CE9');
        $this->addSql('ALTER TABLE regions DROP FOREIGN KEY FK_A26779F3C8121CE9');
        $this->addSql('DROP TABLE continents');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE jwt');
        $this->addSql('DROP TABLE regions');
    }
}
