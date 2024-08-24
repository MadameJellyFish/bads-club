<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240824104036 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add first_name, last_name and birthdate fields in user table';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "user" ADD first_name VARCHAR(50)DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD last_name VARCHAR(50)DEFAULT NULL');
        $this->addSql('ALTER TABLE "user" ADD birthdate DATE DEFAULT NULL');
        $this->addSql('ALTER TABLE user_reservation ALTER reservation_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN user_reservation.reservation_date IS NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP first_name');
        $this->addSql('ALTER TABLE "user" DROP last_name');
        $this->addSql('ALTER TABLE "user" DROP birthdate');
        $this->addSql('ALTER TABLE user_reservation ALTER reservation_date TYPE TIMESTAMP(0) WITHOUT TIME ZONE');
        $this->addSql('COMMENT ON COLUMN user_reservation.reservation_date IS \'(DC2Type:datetime_immutable)\'');
    }
}
