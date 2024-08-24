<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240821192340 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add sportCourt table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sport_court_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sport_court (
          id INT NOT NULL,
          sport_id INT NOT NULL,
          court_name VARCHAR(50) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_D7D27826AC78BCF8 ON sport_court (sport_id)');
        $this->addSql('ALTER TABLE
          sport_court
        ADD
          CONSTRAINT FK_D7D27826AC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sport_court_id_seq CASCADE');
        $this->addSql('ALTER TABLE sport_court DROP CONSTRAINT FK_D7D27826AC78BCF8');
        $this->addSql('DROP TABLE sport_court');
    }
}
