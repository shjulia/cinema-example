<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200502133837 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE schecdule_movie_list (id UUID NOT NULL, movie_id UUID DEFAULT NULL, schedule_id UUID DEFAULT NULL, time_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, time_end TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FD6868D58F93B6FC ON schecdule_movie_list (movie_id)');
        $this->addSql('CREATE INDEX IDX_FD6868D5A40BC2D5 ON schecdule_movie_list (schedule_id)');
        $this->addSql('COMMENT ON COLUMN schecdule_movie_list.movie_id IS \'(DC2Type:movie_id)\'');
        $this->addSql('COMMENT ON COLUMN schecdule_movie_list.schedule_id IS \'(DC2Type:schedule_id)\'');
        $this->addSql('COMMENT ON COLUMN schecdule_movie_list.time_start IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN schecdule_movie_list.time_end IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE schedule (id UUID NOT NULL, week_number INT NOT NULL, week_day INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN schedule.id IS \'(DC2Type:schedule_id)\'');
        $this->addSql('CREATE TABLE genres (id UUID NOT NULL, title VARCHAR(32) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE movies (id UUID NOT NULL, genre_id UUID DEFAULT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_C61EED304296D31F ON movies (genre_id)');
        $this->addSql('COMMENT ON COLUMN movies.id IS \'(DC2Type:movie_id)\'');
        $this->addSql('ALTER TABLE schecdule_movie_list ADD CONSTRAINT FK_FD6868D58F93B6FC FOREIGN KEY (movie_id) REFERENCES movies (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE schecdule_movie_list ADD CONSTRAINT FK_FD6868D5A40BC2D5 FOREIGN KEY (schedule_id) REFERENCES schedule (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE movies ADD CONSTRAINT FK_C61EED304296D31F FOREIGN KEY (genre_id) REFERENCES genres (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE schecdule_movie_list DROP CONSTRAINT FK_FD6868D5A40BC2D5');
        $this->addSql('ALTER TABLE movies DROP CONSTRAINT FK_C61EED304296D31F');
        $this->addSql('ALTER TABLE schecdule_movie_list DROP CONSTRAINT FK_FD6868D58F93B6FC');
        $this->addSql('DROP TABLE schecdule_movie_list');
        $this->addSql('DROP TABLE schedule');
        $this->addSql('DROP TABLE genres');
        $this->addSql('DROP TABLE movies');
    }
}
