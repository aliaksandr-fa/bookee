<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230227162811 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_passengers (id UUID NOT NULL, phone VARCHAR(20) NOT NULL, name_first_name VARCHAR(30) NOT NULL, name_last_name VARCHAR(30) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN booking_passengers.id IS \'(DC2Type:booking_passenger_id)\'');
        $this->addSql('COMMENT ON COLUMN booking_passengers.phone IS \'(DC2Type:booking_passenger_phone)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE booking_passengers');
    }
}
