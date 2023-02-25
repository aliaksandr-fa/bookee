<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230225214233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE booking_bookings (id UUID NOT NULL, seats SMALLINT NOT NULL, passenger_id UUID NOT NULL, booked_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, trip_id UUID DEFAULT NULL, PRIMARY KEY(id, seats, passenger_id, booked_at))');
        $this->addSql('CREATE INDEX IDX_41B1A2B8A5BC2E0E ON booking_bookings (trip_id)');
        $this->addSql('COMMENT ON COLUMN booking_bookings.id IS \'(DC2Type:booking_booking_id)\'');
        $this->addSql('COMMENT ON COLUMN booking_bookings.passenger_id IS \'(DC2Type:booking_passenger_id)\'');
        $this->addSql('COMMENT ON COLUMN booking_bookings.booked_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking_bookings.trip_id IS \'(DC2Type:booking_trip_id)\'');
        $this->addSql('CREATE TABLE booking_trips (id UUID NOT NULL, departs_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, route_id UUID NOT NULL, seats SMALLINT NOT NULL, driver VARCHAR(255) DEFAULT NULL, bus VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN booking_trips.id IS \'(DC2Type:booking_trip_id)\'');
        $this->addSql('COMMENT ON COLUMN booking_trips.departs_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN booking_trips.route_id IS \'(DC2Type:booking_route_id)\'');
        $this->addSql('COMMENT ON COLUMN booking_trips.driver IS \'(DC2Type:booking_driver)\'');
        $this->addSql('COMMENT ON COLUMN booking_trips.bus IS \'(DC2Type:booking_bus_plate_number)\'');
        $this->addSql('ALTER TABLE booking_bookings ADD CONSTRAINT FK_41B1A2B8A5BC2E0E FOREIGN KEY (trip_id) REFERENCES booking_trips (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE booking_bookings DROP CONSTRAINT FK_41B1A2B8A5BC2E0E');
        $this->addSql('DROP TABLE booking_bookings');
        $this->addSql('DROP TABLE booking_trips');
    }
}
