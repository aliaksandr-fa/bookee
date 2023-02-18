<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Scheduling\Bus\Bus;
use Bookee\Domain\Scheduling\Driver\Driver;
use Bookee\Domain\Scheduling\Route;
use Bookee\Domain\Scheduling\Schedule;
use Bookee\Domain\Scheduling\ScheduleId;
use Bookee\Domain\Scheduling\Timetable\CruisingDay;
use Bookee\Domain\Scheduling\Timetable\Timetable;
use Bookee\Domain\Scheduling\Trip;
use Bookee\Domain\Scheduling\TripCollection;
use Bookee\Domain\Scheduling\TripId;
use Bookee\Infrastructure\DataFixtures\Navigation\RoutesFixtures as NavigationRoutesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;


/**
 * Class SchedulesFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Scheduling
 */
class SchedulesFixtures
//    extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $date = (new \DateTimeImmutable())->modify('+ 1 month');

        $this->loadSchedulesForRoute($manager, 'scheduling_' . NavigationRoutesFixtures::ROUTE_101_ALIAS, $date);
        $this->loadSchedulesForRoute($manager, 'scheduling_' . NavigationRoutesFixtures::ROUTE_101_ALIAS . '_back', $date);

        $this->loadSchedulesForRoute($manager, 'scheduling_' . NavigationRoutesFixtures::ROUTE_102_ALIAS, $date);
        $this->loadSchedulesForRoute($manager, 'scheduling_' . NavigationRoutesFixtures::ROUTE_102_ALIAS . '_back', $date);

        $manager->flush();
    }

    private function loadSchedulesForRoute(ObjectManager $manager, string $routeAlias, \DateTimeImmutable $date)
    {
        $faker = Factory::create();

        /** @var Route $route */
        $route = $this->getReference($routeAlias, Route::class);

        foreach (CruisingDay::cases() as $cruisingDay)
        {

            if ($this->hasReference($routeAlias . '_timetable_' . $cruisingDay->name))
            {
                /** @var Timetable $timetable */
                $timetable = $this->getReference($routeAlias . '_timetable_' . $cruisingDay->name, Timetable::class);


                $schedule = new Schedule(
                    ScheduleId::next(),
                    $date,
                    $route->id(),
                    $timetable->id()
                );

                foreach ($this->generateTrips($timetable, $faker->boolean()) as $trip)
                {
                    $schedule->addTrip($trip);
                }

                $manager->persist($schedule);
            }
        }
    }

    private function generateTrips(Timetable $timetable, bool $allocateDriverAndBus): TripCollection
    {
        $trips = new TripCollection();

        $driver = null;
        $bus = null;

        foreach ($timetable->departures() as $departure)
        {
            if ($allocateDriverAndBus)
            {
                list($driver, $bus) = $this->getDriverAndBus();
            }

            $trips->add(
                new Trip(
                    TripId::next(),
                    $driver,
                    $bus
                )
            );
        }

        return $trips;
    }

    private function getDriverAndBus(): array
    {
        $faker = Factory::create();

        $driver = $this->getReference(
            'scheduling_driver_' . $faker->numberBetween(0, DriversFixtures::DRIVERS_COUNT - 1),
            Driver::class
        );

        $bus = $this->getReference(
            'scheduling_bus_' . $faker->numberBetween(0, BusesFixtures::BUSES_COUNT - 1),
            Bus::class
        );

        return [$driver, $bus];
    }

    public function getDependencies(): array
    {
        return [
            RoutesFixtures::class,
            TimetablesFixtures::class,
            DriversFixtures::class,
            BusesFixtures::class
        ];
    }
}
