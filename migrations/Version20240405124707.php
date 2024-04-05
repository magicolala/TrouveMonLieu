<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405124707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE score ADD COLUMN score INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__score AS SELECT id, city_id, user_id, distance FROM score');
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, user_id INTEGER NOT NULL, distance DOUBLE PRECISION NOT NULL, CONSTRAINT FK_329937518BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_32993751A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO score (id, city_id, user_id, distance) SELECT id, city_id, user_id, distance FROM __temp__score');
        $this->addSql('DROP TABLE __temp__score');
        $this->addSql('CREATE INDEX IDX_329937518BAC62AF ON score (city_id)');
        $this->addSql('CREATE INDEX IDX_32993751A76ED395 ON score (user_id)');
    }
}
