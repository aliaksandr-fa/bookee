<?php declare(strict_types=1);

namespace Bookee\Infrastructure\DataFixtures\Scheduling;

use Bookee\Domain\Navigation\Route;
use Bookee\Domain\Scheduling\RouteId;
use Bookee\Domain\Scheduling\Timetable\CruisingDay;
use Bookee\Domain\Scheduling\Timetable\Time;
use Bookee\Domain\Scheduling\Timetable\Departures;
use Bookee\Domain\Scheduling\Timetable\Timetable;
use Bookee\Domain\Scheduling\Timetable\TimetableId;
use Bookee\Infrastructure\DataFixtures\Navigation\RoutesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;


/**
 * Class TimetablesFixtures
 *
 * @package Bookee\Infrastructure\DataFixtures\Navigation
 */
class TimetablesFixtures extends Fixture implements DependentFixtureInterface
{
    const TIMETABLES = [
        [
            [CruisingDay::MONDAY, ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '15:30', '16:00']],
            [CruisingDay::TUESDAY, ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '15:30', '15:40', '15:45', '16:00']],
            [CruisingDay::WEDNESDAY, ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '15:30', '16:00']],
            [CruisingDay::THURSDAY, ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '15:30', '16:00']],
            [CruisingDay::FRIDAY, ['08:00', '09:00', '10:00', '11:00', '14:00', '15:00', '15:30', '16:00']],
            [CruisingDay::SATURDAY, ['08:00', '20:00', '20:30', '20:50']],
            [CruisingDay::SUNDAY, ['08:00', '15:30', '20:00']],
        ],
        [
            [CruisingDay::MONDAY, ['08:20', '09:20', '10:20', '14:20', '15:20', '15:50', '16:20']],
            [CruisingDay::TUESDAY, ['08:20', '09:20', '10:20', '14:20', '15:20', '15:50', '16:20']],
            [CruisingDay::WEDNESDAY, ['08:20', '09:20', '10:20', '14:20', '15:20', '15:50', '16:20']],
            [CruisingDay::THURSDAY, ['08:20', '09:20', '10:20', '14:20', '15:20', '15:50', '16:20']],
            [CruisingDay::FRIDAY, ['08:20', '09:20', '10:20', '14:20', '15:20', '15:50', '16:20']],
            [CruisingDay::SATURDAY, ['08:20', '20:20']],
            [CruisingDay::SUNDAY, ['08:20', '20:20']],
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        /** @var Route $route101 */
        $route101 = $this->getReference(RoutesFixtures::ROUTE_101_ALIAS);

        $this->loadTimetablesForRoute(
            manager: $manager,
            timetablesData: self::TIMETABLES[0],
            routeId: new RouteId($route101->id()->value()),
            alias: RoutesFixtures::ROUTE_101_ALIAS
        );

        $route101Back = $this->getReference(RoutesFixtures::ROUTE_101_ALIAS . '_back');

        $this->loadTimetablesForRoute(
            manager: $manager,
            timetablesData: self::TIMETABLES[1],
            routeId: new RouteId($route101Back->id()->value()),
            alias: RoutesFixtures::ROUTE_101_ALIAS . '_back'
        );

        /** @var Route $route101 */
        $route102 = $this->getReference(RoutesFixtures::ROUTE_102_ALIAS);

        $this->loadTimetablesForRoute(
            manager: $manager,
            timetablesData: self::TIMETABLES[0],
            routeId: new RouteId($route102->id()->value()),
            alias: RoutesFixtures::ROUTE_102_ALIAS
        );

        $route102Back = $this->getReference(RoutesFixtures::ROUTE_102_ALIAS . '_back');

        $this->loadTimetablesForRoute(
            manager: $manager,
            timetablesData: self::TIMETABLES[1],
            routeId: new RouteId($route102Back->id()->value()),
            alias: RoutesFixtures::ROUTE_102_ALIAS . '_back'
        );

        $manager->flush();
    }

    private function loadTimetablesForRoute(ObjectManager $manager, array $timetablesData, RouteId $routeId, string $alias): void
    {
        foreach ($timetablesData as $data)
        {
            $timetable = new Timetable(
                TimetableId::next(),
                $routeId,
                $data[0],
                new Departures(...array_map(fn($time) => Time::fromString($time), $data[1]))
            );

            $this->setReference('scheduling_' . $alias . '_timetable_' . $data[0]->name, $timetable);

            $manager->persist($timetable);
        }
    }

    public function getDependencies(): array
    {
        return [RoutesFixtures::class];
    }
}
