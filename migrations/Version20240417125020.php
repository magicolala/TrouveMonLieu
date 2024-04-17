<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240417125020 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE score');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game_score AS SELECT id, game_id, user_id, round, score FROM game_score');
        $this->addSql('DROP TABLE game_score');
        $this->addSql('CREATE TABLE game_score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_id INTEGER NOT NULL, user_id INTEGER DEFAULT NULL, round INTEGER NOT NULL, score INTEGER DEFAULT NULL, CONSTRAINT FK_AA4EDEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA4EDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO game_score (id, game_id, user_id, round, score) SELECT id, game_id, user_id, round, score FROM __temp__game_score');
        $this->addSql('DROP TABLE __temp__game_score');
        $this->addSql('CREATE INDEX IDX_AA4EDEA76ED395 ON game_score (user_id)');
        $this->addSql('CREATE INDEX IDX_AA4EDEE48FD905 ON game_score (game_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, city_id INTEGER NOT NULL, user_id INTEGER NOT NULL, distance DOUBLE PRECISION NOT NULL, score INTEGER NOT NULL, CONSTRAINT FK_329937518BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_32993751A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_32993751A76ED395 ON score (user_id)');
        $this->addSql('CREATE INDEX IDX_329937518BAC62AF ON score (city_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__game_score AS SELECT id, game_id, user_id, round, score FROM game_score');
        $this->addSql('DROP TABLE game_score');
        $this->addSql('CREATE TABLE game_score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, round INTEGER NOT NULL, score INTEGER DEFAULT NULL, CONSTRAINT FK_AA4EDEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA4EDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO game_score (id, game_id, user_id, round, score) SELECT id, game_id, user_id, round, score FROM __temp__game_score');
        $this->addSql('DROP TABLE __temp__game_score');
        $this->addSql('CREATE INDEX IDX_AA4EDEE48FD905 ON game_score (game_id)');
        $this->addSql('CREATE INDEX IDX_AA4EDEA76ED395 ON game_score (user_id)');
    }
}
