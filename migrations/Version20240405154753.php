<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240405154753 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE game (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, rounds INTEGER NOT NULL, CONSTRAINT FK_232B318CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_232B318CA76ED395 ON game (user_id)');
        $this->addSql('CREATE TABLE game_city (game_id INTEGER NOT NULL, city_id INTEGER NOT NULL, PRIMARY KEY(game_id, city_id), CONSTRAINT FK_C64E6E18E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_C64E6E188BAC62AF FOREIGN KEY (city_id) REFERENCES city (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_C64E6E18E48FD905 ON game_city (game_id)');
        $this->addSql('CREATE INDEX IDX_C64E6E188BAC62AF ON game_city (city_id)');
        $this->addSql('CREATE TABLE game_user (game_id INTEGER NOT NULL, user_id INTEGER NOT NULL, PRIMARY KEY(game_id, user_id), CONSTRAINT FK_6686BA65E48FD905 FOREIGN KEY (game_id) REFERENCES game (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_6686BA65A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_6686BA65E48FD905 ON game_user (game_id)');
        $this->addSql('CREATE INDEX IDX_6686BA65A76ED395 ON game_user (user_id)');
        $this->addSql('CREATE TABLE game_score (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, game_id INTEGER DEFAULT NULL, user_id INTEGER DEFAULT NULL, round INTEGER NOT NULL, score INTEGER DEFAULT NULL, CONSTRAINT FK_AA4EDEE48FD905 FOREIGN KEY (game_id) REFERENCES game (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_AA4EDEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_AA4EDEE48FD905 ON game_score (game_id)');
        $this->addSql('CREATE INDEX IDX_AA4EDEA76ED395 ON game_score (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE game');
        $this->addSql('DROP TABLE game_city');
        $this->addSql('DROP TABLE game_user');
        $this->addSql('DROP TABLE game_score');
    }
}
