<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825115225 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE sport_court_availability_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE sport_court_availability (
          id INT NOT NULL,
          court_id INT NOT NULL,
          court_availability_start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          court_availability_end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_BECF667EE3184009 ON sport_court_availability (court_id)');
        $this->addSql('ALTER TABLE
          sport_court_availability
        ADD
          CONSTRAINT FK_BECF667EE3184009 FOREIGN KEY (court_id) REFERENCES "sports_courts" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE sport_court_availability_id_seq CASCADE');
        $this->addSql('ALTER TABLE sport_court_availability DROP CONSTRAINT FK_BECF667EE3184009');
        $this->addSql('DROP TABLE sport_court_availability');
    }
}
