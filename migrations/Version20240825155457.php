<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825155457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table user_availability';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "days_of_week_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_availability_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "days_of_week" (id INT NOT NULL, day_name VARCHAR(10) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE user_availability (
          id INT NOT NULL,
          related_user_id UUID NOT NULL,
          day_of_week_id INT NOT NULL,
          user_availability_start_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          user_availability_end_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_BF7BDEBD98771930 ON user_availability (related_user_id)');
        $this->addSql('CREATE INDEX IDX_BF7BDEBD139A4A41 ON user_availability (day_of_week_id)');
        $this->addSql('COMMENT ON COLUMN user_availability.related_user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE
          user_availability
        ADD
          CONSTRAINT FK_BF7BDEBD98771930 FOREIGN KEY (related_user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_availability
        ADD
          CONSTRAINT FK_BF7BDEBD139A4A41 FOREIGN KEY (day_of_week_id) REFERENCES "days_of_week" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE sport_court_availability ADD day_id INT NOT NULL');
        $this->addSql('ALTER TABLE
          sport_court_availability
        ADD
          CONSTRAINT FK_BECF667E9C24126 FOREIGN KEY (day_id) REFERENCES "days_of_week" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_BECF667E9C24126 ON sport_court_availability (day_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE sport_court_availability DROP CONSTRAINT FK_BECF667E9C24126');
        $this->addSql('DROP SEQUENCE "days_of_week_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE user_availability_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_availability DROP CONSTRAINT FK_BF7BDEBD98771930');
        $this->addSql('ALTER TABLE user_availability DROP CONSTRAINT FK_BF7BDEBD139A4A41');
        $this->addSql('DROP TABLE "days_of_week"');
        $this->addSql('DROP TABLE user_availability');
        $this->addSql('DROP INDEX IDX_BECF667E9C24126');
        $this->addSql('ALTER TABLE sport_court_availability DROP day_id');
    }
}
