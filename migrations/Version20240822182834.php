<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240822182834 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE address_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE reservation_status_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_reservation_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE address (
          id INT NOT NULL,
          address VARCHAR(255) NOT NULL,
          city VARCHAR(255) NOT NULL,
          country VARCHAR(255) NOT NULL,
          zipcode VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE reservation_status (
          id INT NOT NULL,
          status_name VARCHAR(20) NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE TABLE user_reservation (
          id INT NOT NULL,
          court_id INT NOT NULL,
          status_id INT NOT NULL,
          user_id UUID NOT NULL,
          reservation_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
          PRIMARY KEY(id)
        )');
        $this->addSql('CREATE INDEX IDX_EBD380C0E3184009 ON user_reservation (court_id)');
        $this->addSql('CREATE INDEX IDX_EBD380C06BF700BD ON user_reservation (status_id)');
        $this->addSql('CREATE INDEX IDX_EBD380C0A76ED395 ON user_reservation (user_id)');
        $this->addSql('COMMENT ON COLUMN user_reservation.user_id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN user_reservation.reservation_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT FK_EBD380C0E3184009 FOREIGN KEY (court_id) REFERENCES sport_court (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT FK_EBD380C06BF700BD FOREIGN KEY (status_id) REFERENCES reservation_status (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE
          user_reservation
        ADD
          CONSTRAINT FK_EBD380C0A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD address_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE
          "user"
        ADD
          CONSTRAINT FK_8D93D649F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_8D93D649F5B7AF75 ON "user" (address_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP CONSTRAINT FK_8D93D649F5B7AF75');
        $this->addSql('DROP SEQUENCE address_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE reservation_status_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_reservation_id_seq CASCADE');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT FK_EBD380C0E3184009');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT FK_EBD380C06BF700BD');
        $this->addSql('ALTER TABLE user_reservation DROP CONSTRAINT FK_EBD380C0A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE reservation_status');
        $this->addSql('DROP TABLE user_reservation');
        $this->addSql('DROP INDEX IDX_8D93D649F5B7AF75');
        $this->addSql('ALTER TABLE "user" DROP address_id');
    }
}
