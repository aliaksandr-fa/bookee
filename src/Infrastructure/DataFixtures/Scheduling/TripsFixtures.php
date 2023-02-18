<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\Timetable\CruisingDay;
use Bookee\Domain\Scheduling\Timetable\Timetable;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripId;
use Bookee\Infrastructure\DataFixtures\Navigation\RoutesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


/**
 * Class TripsFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Scheduling
 */
class TripsFixtures extends Fixture implements DependentFixtureInterface
{
    public const LOAD_FOR_DAYS = 10;

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < self::LOAD_FOR_DAYS; $i++)
        {
            $date = (new \DateTimeImmutable())->modify("+ $i days");

            $this->loadTripsForCruisingDayAndRoute($manager, $date, RoutesFixtures::ROUTE_101_ALIAS);
        }

        $manager->flush();
    }

    private function loadTripsForCruisingDayAndRoute(ObjectManager $manager, \DateTimeImmutable $date, string $routeAlias): void
    {
        $day = CruisingDay::from((int) date('N', $date->getTimestamp()));

        /** @var Timetable $timetable */
        $timetable = $this->getReference("scheduling_{$routeAlias}_timetable_{$day->name}" , Timetable::class);

        /** @var Route $route */
        $route = $this->getReference("scheduling_{$routeAlias}" , Route::class);

        $driversToAllocateCount = $this->calculateNumberOfDriversForAllocation($timetable);

        $currentDriver = 0;

        foreach ($timetable->departures() as $departure)
        {
            $trip = new Trip(
                TripId::next(),
                $route->id(),
                $date->modify($departure->format()),
                $route->duration()
            );

            /** @var Driver $driver */
            $driver = $this->getReference("scheduling_driver_{$currentDriver}", Driver::class);

            $trip->assignDriver($driver);
            $trip->assignBus($this->getBus($driver));

            $currentDriver = $currentDriver % $driversToAllocateCount;
            $currentDriver++;

            $manager->persist($trip);
        }
    }

    private function calculateNumberOfDriversForAllocation(Timetable $timetable): int
    {
        return intdiv($timetable->departures()->count(), 2) < DriversFixtures::DRIVERS_COUNT
            ? intdiv($timetable->departures()->count(), 2)
            : DriversFixtures::DRIVERS_COUNT
        ;
    }

    private function getBus(Driver $driver): ?Bus
    {
        if ($driver->getCurrentBusId())
        {
            return $this->getReference("scheduling_bus_{$driver->getCurrentBusId()}", Bus::class);
        }

        return null;
    }

    public function getDependencies(): array
    {
        return [
            RoutesFixtures::class,
            DriversFixtures::class,
            TimetablesFixtures::class
        ];
    }
}
