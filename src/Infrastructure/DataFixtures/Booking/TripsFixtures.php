<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Booking;

use Bookee\Domain\Booking\Bus\BusPlateNumber;
use Bookee\Domain\Booking\Driver\Driver;
use Bookee\Domain\Booking\RouteId;
use Bookee\Domain\Booking\Trip;
use Bookee\Domain\Booking\TripId;
use Bookee\Domain\Scheduling\Bus\Bus as SchedulingBus;
use Bookee\Domain\Scheduling\Driver\Driver as SchedulingDriver;
use Bookee\Domain\Scheduling\Trip as SchedulingTrip;
use Bookee\Infrastructure\DataFixtures\Scheduling\TripsFixtures as SchedulingTripsFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


/**
 * Class TripsFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Booking
 */
class TripsFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < SchedulingTripsFixtures::$tripsCounter; $i++)
        {
            /** @var SchedulingTrip $schedulingTrip */
            $schedulingTrip = $this->getReference("scheduling_trip_$i", SchedulingTrip::class);

            $driver = null;
            $bus = null;

            if ($schedulingTrip->driverId())
            {
                /** @var SchedulingDriver $schedulingDriver */
                $schedulingDriver = $this->getReference("scheduling_driver_{$schedulingTrip->driverId()->value()}", SchedulingDriver::class);
                $driver = new Driver($schedulingDriver->name(), $schedulingDriver->phoneNumber()->number());
            }

            if ($schedulingTrip->busId())
            {
                /** @var SchedulingBus $schedulingBus */
                $schedulingBus = $this->getReference("scheduling_bus_{$schedulingTrip->busId()->value()}", SchedulingBus::class);
                $bus = new BusPlateNumber($schedulingBus->plateNumber()->number());
            }

            $trip = new Trip(
                TripId::next(),
                new RouteId($schedulingTrip->routeId()->value()),
                $schedulingTrip->departsAt(),
                $schedulingTrip->seats(),
                $driver,
                $bus
            );

            $manager->persist($trip);
        }

        $manager->flush();
    }


    public function getDependencies()
    {
        return [
            SchedulingTripsFixtures::class
        ];
    }
}