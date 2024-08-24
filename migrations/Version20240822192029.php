<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822192029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table praticeLevel';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE practice_level_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE practice_level (
          id INT NOT NULL,
          level_name VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE user_sport (
          user_id UUID NOT NULL,
          sport_id INT NOT NULL,
          practice_level_id INT NOT NULL,
          PRIMARY KEY(
            user_id, sport_id, practice_level_id
          )
        )');
        $this->addSql('CREATE INDEX IDX_F847148AA76ED395 ON user_sport (user_id)');
        $this->addSql('CREATE INDEX IDX_F847148AAC78BCF8 ON user_sport (sport_id)');
        $this->addSql('CREATE INDEX IDX_F847148A58D2F8A2 ON user_sport (practice_level_id)');
        $this->addSql('COMMENT ON COLUMN user_sport.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT FK_F847148AA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT FK_F847148AAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT FK_F847148A58D2F8A2 FOREIGN KEY (practice_level_id) REFERENCES practice_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE practice_level_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT FK_F847148AA76ED395');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT FK_F847148AAC78BCF8');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT FK_F847148A58D2F8A2');
        $this->addSql('DROP TABLE practice_level');
        $this->addSql('DROP TABLE user_sport');
    }
}
