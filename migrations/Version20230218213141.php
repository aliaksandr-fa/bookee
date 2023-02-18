<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230218213141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE navigation_routes_stops_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE navigation_routes (id UUID NOT NULL, name VARCHAR(150) NOT NULL, number INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN navigation_routes.id IS \'(DC2Type:navigation_route_id)\'');
        $this->addSql('CREATE TABLE navigation_routes_stops (id INT NOT NULL, route_id UUID DEFAULT NULL, eta SMALLINT DEFAULT NULL, stop_order INT NOT NULL, stop_id UUID NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_905C0B4C34ECB4E6 ON navigation_routes_stops (route_id)');
        $this->addSql('COMMENT ON COLUMN navigation_routes_stops.route_id IS \'(DC2Type:navigation_route_id)\'');
        $this->addSql('COMMENT ON COLUMN navigation_routes_stops.stop_id IS \'(DC2Type:navigation_stop_id)\'');
        $this->addSql('CREATE TABLE navigation_stops (id UUID NOT NULL, title VARCHAR(150) NOT NULL, location_latitude DOUBLE PRECISION NOT NULL, location_longitude DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN navigation_stops.id IS \'(DC2Type:navigation_stop_id)\'');
        $this->addSql('CREATE TABLE scheduling_buses (id UUID NOT NULL, plate_number VARCHAR(255) NOT NULL, seats SMALLINT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN scheduling_buses.id IS \'(DC2Type:scheduling_bus_bus_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_buses.plate_number IS \'(DC2Type:scheduling_bus_plate_number)\'');
        $this->addSql('CREATE TABLE scheduling_drivers (id UUID NOT NULL, name VARCHAR(100) NOT NULL, phone_number VARCHAR(255) NOT NULL, buses TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN scheduling_drivers.id IS \'(DC2Type:scheduling_driver_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_drivers.phone_number IS \'(DC2Type:scheduling_driver_phone_number)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_drivers.buses IS \'(DC2Type:scheduling_driver_drivable_buses)\'');
        $this->addSql('CREATE TABLE scheduling_routes (id UUID NOT NULL, name VARCHAR(255) NOT NULL, duration INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN scheduling_routes.id IS \'(DC2Type:scheduling_route_id)\'');
        $this->addSql('CREATE TABLE scheduling_timetables (id UUID NOT NULL, route_id UUID NOT NULL, day SMALLINT NOT NULL, departures TEXT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN scheduling_timetables.id IS \'(DC2Type:scheduling_timetable_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_timetables.route_id IS \'(DC2Type:scheduling_route_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_timetables.day IS \'(DC2Type:scheduling_cruising_day)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_timetables.departures IS \'(DC2Type:scheduling_departures)\'');
        $this->addSql('CREATE TABLE scheduling_trips (id UUID NOT NULL, status VARCHAR(15) NOT NULL, seats SMALLINT DEFAULT NULL, duration INT NOT NULL, departs_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, route_id UUID NOT NULL, driver_id UUID DEFAULT NULL, bus_id UUID DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.id IS \'(DC2Type:scheduling_trip_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.status IS \'(DC2Type:scheduling_trip_status)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.departs_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.route_id IS \'(DC2Type:scheduling_route_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.driver_id IS \'(DC2Type:scheduling_driver_id)\'');
        $this->addSql('COMMENT ON COLUMN scheduling_trips.bus_id IS \'(DC2Type:scheduling_bus_bus_id)\'');
        $this->addSql('ALTER TABLE navigation_routes_stops ADD CONSTRAINT FK_905C0B4C34ECB4E6 FOREIGN KEY (route_id) REFERENCES navigation_routes (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE navigation_routes_stops_id_seq CASCADE');
        $this->addSql('ALTER TABLE navigation_routes_stops DROP CONSTRAINT FK_905C0B4C34ECB4E6');
        $this->addSql('DROP TABLE navigation_routes');
        $this->addSql('DROP TABLE navigation_routes_stops');
        $this->addSql('DROP TABLE navigation_stops');
        $this->addSql('DROP TABLE scheduling_buses');
        $this->addSql('DROP TABLE scheduling_drivers');
        $this->addSql('DROP TABLE scheduling_routes');
        $this->addSql('DROP TABLE scheduling_timetables');
        $this->addSql('DROP TABLE scheduling_trips');
    }
}
