<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240825090518 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Change tables name';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE sport_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE sport_court_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_reservation_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE practice_level_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE "addresses_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "practice_levels_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "sports_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "sports_courts_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "users_reservations_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "addresses" (
          id INT NOT NULL,
          address VARCHAR(255) NOT NULL,
          city VARCHAR(255) NOT NULL,
          country VARCHAR(255) NOT NULL,
          zipcode VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE "practice_levels" (
          id INT NOT NULL,
          level_name VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE "sports" (id INT NOT NULL, sport_name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_73C9F91C29FC50FA ON "sports" (sport_name)');
        $this->addSql('CREATE TABLE "sports_courts" (
          id INT NOT NULL,
          sport_id INT NOT NULL,
          court_name VARCHAR(50) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_5B54901FAC78BCF8 ON "sports_courts" (sport_id)');
        $this->addSql('CREATE TABLE "users" (
          id UUID NOT NULL,
          address_id INT DEFAULT NULL,
          email VARCHAR(180) NOT NULL,
          roles JSON NOT NULL,
          password VARCHAR(255) NOT NULL,
          first_name VARCHAR(50) DEFAULT NULL,
          last_name VARCHAR(50) DEFAULT NULL,
          birthdate DATE DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_1483A5E9F5B7AF75 ON "users" (address_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON "users" (email)');
        $this->addSql('COMMENT ON COLUMN "users".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "users_reservations" (
          id INT NOT NULL,
          court_id INT NOT NULL,
          status_id INT NOT NULL,
          user_id UUID NOT NULL,
          reservation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_53098435E3184009 ON "users_reservations" (court_id)');
        $this->addSql('CREATE INDEX IDX_530984356BF700BD ON "users_reservations" (status_id)');
        $this->addSql('CREATE INDEX IDX_53098435A76ED395 ON "users_reservations" (user_id)');
        $this->addSql('COMMENT ON COLUMN "users_reservations".user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE "users_sports" (
          user_id UUID NOT NULL,
          sport_id INT NOT NULL,
          practice_level_id INT NOT NULL,
          PRIMARY KEY(
            user_id, sport_id, practice_level_id
          )
        )');
        $this->addSql('CREATE INDEX IDX_7C2E778CA76ED395 ON "users_sports" (user_id)');
        $this->addSql('CREATE INDEX IDX_7C2E778CAC78BCF8 ON "users_sports" (sport_id)');
        $this->addSql('CREATE INDEX IDX_7C2E778C58D2F8A2 ON "users_sports" (practice_level_id)');
        $this->addSql('COMMENT ON COLUMN "users_sports".user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE
          "sports_courts"
        ADD
          CONSTRAINT FK_5B54901FAC78BCF8 FOREIGN KEY (sport_id) REFERENCES "sports" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users"
        ADD
          CONSTRAINT FK_1483A5E9F5B7AF75 FOREIGN KEY (address_id) REFERENCES "addresses" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_reservations"
        ADD
          CONSTRAINT FK_53098435E3184009 FOREIGN KEY (court_id) REFERENCES "sports_courts" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_reservations"
        ADD
          CONSTRAINT FK_530984356BF700BD FOREIGN KEY (status_id) REFERENCES reservation_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_reservations"
        ADD
          CONSTRAINT FK_53098435A76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_sports"
        ADD
          CONSTRAINT FK_7C2E778CA76ED395 FOREIGN KEY (user_id) REFERENCES "users" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_sports"
        ADD
          CONSTRAINT FK_7C2E778CAC78BCF8 FOREIGN KEY (sport_id) REFERENCES "sports" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          "users_sports"
        ADD
          CONSTRAINT FK_7C2E778C58D2F8A2 FOREIGN KEY (practice_level_id) REFERENCES "practice_levels" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT fk_8d93d649f5b7af75');
        $this->addSql('ALTER TABLE sport_court DROP CONSTRAINT fk_d7d27826ac78bcf8');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT fk_ebd380c0e3184009');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT fk_ebd380c06bf700bd');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT fk_ebd380c0a76ed395');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT fk_f847148aa76ed395');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT fk_f847148aac78bcf8');
        $this->addSql('ALTER TABLE user_sport DROP CONSTRAINT fk_f847148a58d2f8a2');
        $this->addSql('DROP TABLE "user"');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE sport_court');
        $this->addSql('DROP TABLE user_reservation');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE user_sport');
        $this->addSql('DROP TABLE practice_level');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE "addresses_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "practice_levels_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "sports_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "sports_courts_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "users_reservations_id_seq" CASCADE');
        $this->addSql('CREATE SEQUENCE sport_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE sport_court_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE practice_level_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "user" (
          id UUID NOT NULL,
          address_id INT DEFAULT NULL,
          email VARCHAR(180) NOT NULL,
          roles JSON NOT NULL,
          password VARCHAR(255) NOT NULL,
          first_name VARCHAR(50) DEFAULT NULL,
          last_name VARCHAR(50) DEFAULT NULL,
          birthdate DATE DEFAULT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX idx_8d93d649f5b7af75 ON "user" (address_id)');
        $this->addSql('DROP INDEX IF EXISTS uniq_identifier_email');
        $this->addSql('CREATE UNIQUE INDEX uniq_identifier_email ON "users" (email)');
        $this->addSql('COMMENT ON COLUMN "user".id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE sport (id INT NOT NULL, sport_name VARCHAR(50) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX uniq_1a85efd229fc50fa ON sport (sport_name)');
        $this->addSql('CREATE TABLE sport_court (
          id INT NOT NULL,
          sport_id INT NOT NULL,
          court_name VARCHAR(50) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX idx_d7d27826ac78bcf8 ON sport_court (sport_id)');
        $this->addSql('CREATE TABLE user_reservation (
          id INT NOT NULL,
          court_id INT NOT NULL,
          status_id INT NOT NULL,
          user_id UUID NOT NULL,
          reservation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX idx_ebd380c0a76ed395 ON user_reservation (user_id)');
        $this->addSql('CREATE INDEX idx_ebd380c06bf700bd ON user_reservation (status_id)');
        $this->addSql('CREATE INDEX idx_ebd380c0e3184009 ON user_reservation (court_id)');
        $this->addSql('COMMENT ON COLUMN user_reservation.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE address (
          id INT NOT NULL,
          address VARCHAR(255) NOT NULL,
          city VARCHAR(255) NOT NULL,
          country VARCHAR(255) NOT NULL,
          zipcode VARCHAR(20) NOT NULL,
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
        $this->addSql('CREATE INDEX idx_f847148a58d2f8a2 ON user_sport (practice_level_id)');
        $this->addSql('CREATE INDEX idx_f847148aac78bcf8 ON user_sport (sport_id)');
        $this->addSql('CREATE INDEX idx_f847148aa76ed395 ON user_sport (user_id)');
        $this->addSql('COMMENT ON COLUMN user_sport.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE practice_level (
          id INT NOT NULL,
          level_name VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('ALTER TABLE
          "user"
        ADD
          CONSTRAINT fk_8d93d649f5b7af75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          sport_court
        ADD
          CONSTRAINT fk_d7d27826ac78bcf8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT fk_ebd380c0e3184009 FOREIGN KEY (court_id) REFERENCES sport_court (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT fk_ebd380c06bf700bd FOREIGN KEY (status_id) REFERENCES reservation_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT fk_ebd380c0a76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT fk_f847148aa76ed395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT fk_f847148aac78bcf8 FOREIGN KEY (sport_id) REFERENCES sport (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_sport
        ADD
          CONSTRAINT fk_f847148a58d2f8a2 FOREIGN KEY (practice_level_id) REFERENCES practice_level (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "sports_courts" DROP CONSTRAINT FK_5B54901FAC78BCF8');
        $this->addSql('ALTER TABLE "users" DROP CONSTRAINT FK_1483A5E9F5B7AF75');
        $this->addSql('ALTER TABLE "users_reservations" DROP CONSTRAINT FK_53098435E3184009');
        $this->addSql('ALTER TABLE "users_reservations" DROP CONSTRAINT FK_530984356BF700BD');
        $this->addSql('ALTER TABLE "users_reservations" DROP CONSTRAINT FK_53098435A76ED395');
        $this->addSql('ALTER TABLE "users_sports" DROP CONSTRAINT FK_7C2E778CA76ED395');
        $this->addSql('ALTER TABLE "users_sports" DROP CONSTRAINT FK_7C2E778CAC78BCF8');
        $this->addSql('ALTER TABLE "users_sports" DROP CONSTRAINT FK_7C2E778C58D2F8A2');
        $this->addSql('DROP TABLE "addresses"');
        $this->addSql('DROP TABLE "practice_levels"');
        $this->addSql('DROP TABLE "sports"');
        $this->addSql('DROP TABLE "sports_courts"');
        $this->addSql('DROP TABLE "users"');
        $this->addSql('DROP TABLE "users_reservations"');
        $this->addSql('DROP TABLE "users_sports"');
    }
}
